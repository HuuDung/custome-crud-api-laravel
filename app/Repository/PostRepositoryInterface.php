<?php
namespace App\Repository;

interface PostRepositoryInterface
{
    //ví dụ: lấy 5 sản phầm đầu tiên
    public function getPost();

    public function uploadFile($file);
}
