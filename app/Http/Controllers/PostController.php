<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Repository\PostRepositoryInterface;
use App\Transformers\PostTransformers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    protected $postRepo;
    //
    public function __construct(PostRepositoryInterface $postRepo)
    {
        $this->postRepo = $postRepo;
    }
    //
    public function index(){
      $post = $this->postRepo->getPost();
      $data = fractal()->collection($post)
                    ->transformWith(new PostTransformers)
                    ->toArray();
      return responseSuccess($data, Response::HTTP_OK, trans('messages.welcome')) ;
    }
}
