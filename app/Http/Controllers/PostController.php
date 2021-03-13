<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Transformers\PostTransformers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    //
    public function index(){
      $post = Post::paginate(5);
      $data = fractal()->collection($post)
      ->transformWith(new PostTransformers)
      ->toArray();
      return response()->json($data, Response::HTTP_OK);
    }
}
