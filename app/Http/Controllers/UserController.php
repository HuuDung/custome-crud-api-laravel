<?php

namespace App\Http\Controllers;

use App\Mail\MailUserRegister;
use App\Jobs\SendNotificationMail;
use App\Jobs\SendRegisterMail;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    protected $userRepo;
    //
    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }
}
