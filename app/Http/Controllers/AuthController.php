<?php

namespace App\Http\Controllers;

use App\Jobs\SendRegisterMail;
use App\Jobs\SendResetPasswordMail;
use App\Repository\PasswordResetRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $userRepo;
    protected $pwResetRepo;
    public function __construct(
        UserRepositoryInterface $userRepo,
        PasswordResetRepositoryInterface $pwResetRepo
    ) {
        $this->userRepo = $userRepo;
        $this->pwResetRepo = $pwResetRepo;
    }
    //
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        $listUserType = config('constant.user_type_number');
        $userType = isset($listUserType[$request->user_type]) ? $listUserType[$request->user_type] : $listUserType[0];
        $guard = config("auth.type.$userType.guard");

        if (!auth($guard)->attempt($credentials))
            return responseMessageFail(trans('messages.auth.login.fail'), Response::HTTP_UNAUTHORIZED);

        $user = auth($guard)->user();

        $tokenResult = $user->createToken($userType);

        $token = $tokenResult->token;

        if ($request->remember_me)
            $token->expries_at = Carbon::now()->addWeek(1);

        $token->save();
        return response()->json([
            'message' => trans('messages.auth.login.success'),
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'refresh_token' => '',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ], Response::HTTP_OK);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return responseMessageSuccess(trans('messages.auth.logout'), Response::HTTP_OK);
    }
    //Create User
    public function signup(Request $request)
    {
        $datas = $request->all();
        $user = $this->userRepo->create($datas);
        $dataMail = [];
        SendRegisterMail::dispatch($user, $dataMail)->delay(now()->addMinute(1));
        return responseMessageSuccess(trans('messages.auth.signup'), Response::HTTP_OK);
    }

}
