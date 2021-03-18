<?php

namespace App\Http\Controllers;

use App\Repository\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepo;
    //
    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }
    //Create User
    public function create(Request $request)
    {
        // $user = $this->userRepo->create($request->all());
        // dd($user);
    }
}
