<?php

namespace App\Http\Controllers\Post\Main;

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

    public function store(Post $post, StoreRequest $request){
        $data = $request->validated();
        $data['user_id'] = Auth::user()->id;
        $data['post_id'] = $post->id;
        Comment::create($data);
        return redirect()->route('post.show', $post->id);
    }

    public function deleteComment(Comment $comment){
        $comment->delete();
        return redirect()->route('comment');
    }
}
