<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{

    public function register()
    {

    }

    /**
     * @param AuthLoginRequest $request
     * @return JsonResponse
     */
    public function login(AuthLoginRequest $request)
    {
        $credentials = $request->validated();
        if (!auth()->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth-token');

        return response()->json([
            'user_id' => $user->id,
            'name' => $user->name,
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function logout()
    {
        Auth::user()->tokens()->delete();

        $response = response()->json([
            'message' => 'Sesión cerrada'
        ], 200);

        $response->withCookie(cookie()->forget('employee_metrics_session'));

        return $response;
    }

}
