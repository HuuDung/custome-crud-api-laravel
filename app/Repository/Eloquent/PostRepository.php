<?php
namespace App\Repository\Eloquent;

use App\Models\Post;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\PostRepositoryInterface;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return Post::class;
    }

    public function getPost()
    {
        return $this->model->paginate(5);
    }
}
