<?php

namespace App\Http\Controllers;

use App\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'store']]);
    }

    public function index()
    {
        $words = Word::published()->paginate(10);

        return view('word.index', compact('words'));
    }

    public function create()
    {
        return view('word.create');
    }

    public function store(Request $request)
    {
        $request->validate(Word::validations());

        return $this->save($request, new Word());
    }

    public function edit()
    {
        return view('words.edit');
    }

    public function update(Request $request, Word $word)
    {
        $request->validate(Word::validations());

        return $this->save($request, $word);
    }

    public function show($id)
    {
        $word = Word::where([
            'is_published' => true
        ])->findOrFail($id);

        return view('word.show', compact('word'));
    }

    public function destroy(Word $word)
    {
        $word->delete();

        return redirect()->route('home');
    }

    public function search(Request $request)
    {
        $search = trim($request->get('q'));
        $words = [];

        if(!empty($search)) {
            $words = Word::published()->where('title', 'like', '%' . $search . '%')->paginate(10);
        }

        return view('word.index', compact('words'));
    }

    private function save(Request $request, Word $word)
    {
        $image = $request->file('image');

        $word->fill($request->all());

        if ($word->user_id === null) {
            $word->user_id = Auth::user()->id;
        }

        if($image) {
            $path = $image->store('words', 'public');
            $word->image = $path;
        }

        $word->is_published = false;

        $word->save();

        return redirect()->route('words.index')->with('success', 'Ваше слово находится на рассмотрении.');
    }
}