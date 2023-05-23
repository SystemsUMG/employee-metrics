<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Response\ResponseController;
use App\Http\Requests\AuthLoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Twilio\Rest\Client;

class AuthController extends ResponseController
{
    public string|array|false $token;
    public string|array|false $twilio_sid;
    public string|array|false $twilio_verify_sid;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->token             = getenv("TWILIO_AUTH_TOKEN");
        $this->twilio_sid        = getenv("TWILIO_SID");
        $this->twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
    }

    public function login(AuthLoginRequest $request)
    {
        $request->validated();

        try {
            $user = User::on($this->database)->where('email', $request->email)->first();

            if (!$user) {
                throw new Exception ('El correo electrónico no está registrado.', 401);
            } else if (!Hash::check($request->password, $user->password)) {
                throw new Exception ('La contraseña es incorrecta.', 401);
            }

            $twilio = new Client($this->twilio_sid, $this->token);
            $twilio->verify->v2->services($this->twilio_verify_sid)
                ->verifications
                ->create($user->phone, "sms");

            $records = ['phone' => $user->phone];

            $this->records = $records;
            $this->result = true;
            $this->message = 'Se ha enviado el código de verificación';
            $this->statusCode = 200;
        } catch (Exception $exception) {
            $this->statusCode = $exception->getCode() ?: $this->statusCode;
            $this->message = $exception->getMessage();
        } finally {
            return $this->jsonResponse($this->result, $this->records, $this->message, $this->statusCode);
        }
    }

    public function verify(Request $request)
    {
        $request->validate([
            'verification_code' => ['required', 'numeric'],
            'phone'             => ['required', 'string'],
        ]);
        try {
            $twilio = new Client($this->twilio_sid, $this->token);
            $verification = $twilio->verify->v2->services($this->twilio_verify_sid)
                ->verificationChecks
                ->create([
                    'Code' => $request->verification_code,
                    'to'   => $request->phone
                ]);

            if ($verification->valid) {
                $credentials = [
                    'email'    => $request->email,
                    'password' => $request->password,
                ];

                $user = User::on($this->database)->where('phone', $request->phone)->firstOrFail();
                $user->update(['isVerified' => true]);
                $user->save();

                if (!auth()->attempt($credentials)) {
                    throw new Exception ('La contraseña es incorrecta.');
                }

                $user->createToken('auth-token');
                $this->result = true;
                $this->message = 'Se ha verificado el número';
            } else {
                $this->message = 'El código ingresado es incorrecto.';
            }
            $this->statusCode = 200;
        } catch (Exception $exception) {
            $this->message = $exception->getMessage();
        } finally {
            return $this->jsonResponse($this->result, $this->records, $this->message, $this->statusCode);
        }
    }

    /**
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();
        Auth::user()->update(['isVerified' => false]);
        return response()->json(['message' => 'Sesión cerrada']);
    }
}
