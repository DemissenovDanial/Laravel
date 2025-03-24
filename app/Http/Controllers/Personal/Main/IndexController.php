<?php

namespace App\Http\Controllers\Personal\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personal\Comment\UpdateRequest;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [
            'postUserLikesCount' => $user->likedPost->count(),
            'postUserCommentsCount' => $user->comments->count()
        ];

        return view('personal.main.index', compact('data'));
    }

    public function liked()
    {
        $posts = Auth::user()->likedPost;
        return view('personal.liked.index', compact('posts'));
    }

    public function comment()
    {
        $comments = Auth::user()->comments;
        return view('personal.comment.index', compact('comments'));
    }

    public function delete(Post $post)
    {
        Auth::user()->LikedPost()->detach($post->id);
        return redirect()->route('liked');
    }

    public function editComment(Comment $comment)
    {
        return view('personal.comment.edit', compact('comment'));
    }

    public function updateComment(UpdateRequest $request, Comment $comment)
    {
        $data = $request->validated();
        $comment->update($data);
        return redirect()->route('comment');
    }

    public function deleteComment(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('comment');
    }
}
