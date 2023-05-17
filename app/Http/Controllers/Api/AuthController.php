<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Twilio\Rest\Client;


class AuthController extends Controller
{

    public function register(AuthLoginRequest $request)
    {
        $request->validated();

        $user = User::where('email', $request->email)->firstOrFail();

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
        }

        /* Get credentials from .env */
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create($user->phone, "sms");

        return response()->json([
            'phone' => $user->phone
        ]);
    }

    /**
     * @param AuthLoginRequest $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'verification_code' => ['required', 'numeric'],
            'phone' => ['required', 'string'],
        ]);
        $status = 400;
        $message = 'No se pudo verificar el número';
        /* Get credentials from .env */
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create(['Code' => $request->verification_code, 'to' => $request->phone]);
        if ($verification->valid) {
            tap(User::where('phone', $request->phone))->update(['isVerified' => true]);
            $user = User::where('phone', $request->phone)->firstOrFail();
            /* Authenticate user */
            if (!auth()->attempt($request->credentials, false, $this->database)) {
                throw ValidationException::withMessages([
                    'email' => [trans('auth.failed')],
                ]);
            }
            $user->createToken('auth-token');
            $message = "Número verificado";
            $status = 200;
        }

        return response()->json($message, $status);
    }

    /**
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();
        tap(Auth::user())->update(['isVerified' => false]);
        Cookie::queue(Cookie::forget('employee_metrics_session'));
        return response()->json([
            'message' => 'Sesión cerrada'
        ], 200);
    }

}
