<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        $listUserType = config('constant.user_type_number');
        $userType = isset($listUserType[$request->user_type]) ? $listUserType[$request->user_type] : $listUserType[0];
        $guard = config("auth.type.$userType.guard");

        if (!auth($guard)->attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], Response::HTTP_UNAUTHORIZED);

        $user = auth($guard)->user();

        $tokenResult = $user->createToken($userType);

        $token = $tokenResult->token;

        if ($request->remember_me)
            $token->expries_at = Carbon::now()->addWeek(1);

        $token->save();
        return response()->json([
            'message' => 'Login success',
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'refresh_token' => '',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
            ], Response::HTTP_OK);
    }
}
