<?php
namespace App\Repository;

use phpDocumentor\Reflection\Types\Boolean;

interface PasswordResetRepositoryInterface
{
    public function createRequest($email);

    public function findByEmailAndToken($email, $token);
}
