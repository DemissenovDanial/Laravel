<?php

namespace App\Http\Controllers\Post\Like;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\Comment\StoreRequest;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index(){
        return view('personal.main.index');
    }

    public function store(Post $post){
        Auth::user()->LikedPost()->toggle($post->id);
        return redirect()->route('post.index', $post->id);
    }

    public function deleteComment(Comment $comment){
        $comment->delete();
        return redirect()->route('comment');
    }
}
