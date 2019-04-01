<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Word $word, Request $request)
    {
        if($word->is_published === false) {
            return redirect()->route('home');
        }

        $request->validate(Comment::validations());

        $comment = new Comment();
        $comment->user_id = Auth::user()->id;
        $comment->fill($request->all());
        $word->comments()->save($comment);

        return redirect()->route('words.show', compact('word'));
    }
}