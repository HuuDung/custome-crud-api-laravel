<?php

namespace App\Repository\Eloquent;

use Illuminate\Support\Str;
use App\Models\PasswordReset;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\PasswordResetRepositoryInterface;
use App\Repository\PostRepositoryInterface;
use App\Traits\FileUploadTrait;
use phpDocumentor\Reflection\Types\Boolean;

class PasswordResetRepository extends BaseRepository implements PasswordResetRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return PasswordReset::class;
    }

    public function createRequest($email)
    {
        $resetPasswords = $this->model->where('email', $email)->get();
        foreach ($resetPasswords as $resetPassword) {
            $resetPassword->delete();
        }
        $token = Str::random(32);
        $attributes = [
            'email' => $email,
            'token' => $token
        ];
        return $this->create($attributes);
    }

    public function findByEmailAndToken($email, $token)
    {
        return $this->model->where('email', $email)
            ->where('token', $token)
            ->first();
    }
}
