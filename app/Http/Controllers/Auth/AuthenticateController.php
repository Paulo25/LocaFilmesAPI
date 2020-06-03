<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Mensagem;
use App\Enums\StatusCode;
use App\Http\Controllers\ApiController;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;


class AuthenticateController extends ApiController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        $token = null;

        if (!$token = JWTAuth::attempt($credentials)) {
            return $this->errorResponse([], 'E-mail ou Senha inválidos', StatusCode::UNPROCESSABLE_ENTITY);
        }
       
        return $this->successResponse(compact('token'), Mensagem::MSG010, StatusCode::OK);
    }


    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->successResponse(auth()->user(), Mensagem::MSG010, StatusCode::OK);
    }

     /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return $this->successResponse([], Mensagem::MSG011, StatusCode::OK);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->successResponse(auth()->refresh(), Mensagem::MSG012, StatusCode::OK);  
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

}
