<?php
namespace App\Repository;

interface UserRepositoryInterface
{
    public function findByEmail($email);

}
