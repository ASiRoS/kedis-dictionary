<?php

namespace App\Http\Controllers;

use App\User;
use App\Word;

class UserController extends Controller
{
    public function words(User $user)
    {
        $words = Word::published()->where('user_id', $user->id)->paginate(10);

        return view('word.index', compact('words'));
    }

    public function mineWords()
    {
        return $this->words(\Auth::user());
    }
}