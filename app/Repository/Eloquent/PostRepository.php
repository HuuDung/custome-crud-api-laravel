<?php
namespace App\Repository\Eloquent;

use App\Models\Post;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\PostRepositoryInterface;
use App\Traits\FileUploadTrait;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    use FileUploadTrait;

    private $folder = 'posts';
    //lấy model tương ứng
    public function getModel()
    {
        return Post::class;
    }

    public function getPost()
    {
        return $this->model->paginate(5);
    }

    public function uploadFile($file)
    {
        $this->folderName = $this->folder;
        return $this->saveFiles($file);
    }
}
