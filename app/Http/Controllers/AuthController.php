<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\UserAuth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct ()
    {
        $this->middleware('auth:api', ['except' => ['login', 'loginBusiness']]);
    }

    public function login (Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = request(['email', 'password']);
        if ( !$token = auth()->attempt($credentials, true)) {
            return response()->json(['error' => 'Unauthorized.'], Response::HTTP_UNAUTHORIZED);
        }
        return $this->respondWithToken($token);
    }

    public function loginBusiness (Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = request(['email', 'password']);
        if ( !$token = auth()->attempt($credentials, true)) {
            return response()->json(['error' => 'Unauthorized.'], Response::HTTP_UNAUTHORIZED);
        }
        /** @var \App\Models\User $user */
        $user = auth()->user();
        if ( !$user->business_id && !$user->is_admin) {
            auth()->logout();
            return response()->json(['error' => 'Unauthorized.'], Response::HTTP_UNAUTHORIZED);
        }
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me ()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        return response()->json(['data' => UserAuth::fromModel($user)]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout ()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh ()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string  $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken ($token)
    {
        $user = auth()->user();
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60 * 50,
            'user'         => UserAuth::fromModel($user)
        ]);
    }

    protected function validateRequest ($request, $update = false)
    {
        // TODO: Implement validateRequest() method.
    }
}
