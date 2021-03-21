<?php

namespace App\Http\Controllers;

use App\Jobs\SendResetPasswordMail;
use App\Repository\PasswordResetRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
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
    public function passwordResetMail(Request $request)
    {
        $email = $request->email;
        $findResult = $this->userRepo->findByEmail($email);
        if (!$findResult)
            return responseMessageFail(trans('messages.auth.reset-password.find-user-fail'), Response::HTTP_FORBIDDEN);
        $resetPassword = $this->pwResetRepo->createRequest($email);
        $dataMail = [
            'email' => $email
        ];
        SendResetPasswordMail::dispatch($email, $dataMail)->delay(now()->addMinute(1));
        return responseMessageSuccess(trans('messages.auth.reset-password.send-request'), Response::HTTP_OK);
    }

    public function passwordReset(Request $request)
    {
        $rspw = $this->pwResetRepo->findByEmailAndToken($request->email, $request->token);

        if (!$rspw)
            return responseMessageFail(trans('messages.auth.reset-password.used'), Response::HTTP_FORBIDDEN);

        if (!$rspw->created_at->gte(Carbon::now()->subMinutes(10)))
            return responseMessageFail(trans('messages.auth.reset-password.expired'), Response::HTTP_FORBIDDEN);

        $user = $this->userRepo->findByEmail($request->email);
        $datas = [
            'password' => $request->password
        ];

        $this->userRepo->update($user->id, $datas);
        $this->pwResetRepo->delete($rspw->id);
        return responseMessageSuccess(trans('messages.auth.reset-password.success'), Response::HTTP_OK);
    }
}
