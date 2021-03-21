<?php
namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\UserRepositoryInterface;
use App\Traits\FileUploadTrait;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return User::class;
    }

    public function findByEmail($email)
    {
        $user = $this->model->where('email', $email)->first();
        return $user;
    }
}
