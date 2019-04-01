@extends('layouts.app')

@section('content')
    <div class="container col-md-10">
        <div class="card">
            @if($word->image)
                <img class="card-img-top" src="{{ asset($word->image) }}" alt="{{ $word->title }}" width="100" height="300">
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $word->title }}</h5>
                <p class="card-text">{{ $word->description }}</p>
            </div>
            <div class="card-footer">
                <small class="text-muted">Добавлено: {{ $word->formatted_date }}</small>
            </div>
        </div>


        @if(Auth::user())
            <div class="card mt-3">
                <div class="card-header">Добавить комментарий</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('comments.store', ['word' => $word]) }}">
                        @include('layouts.errors')

                        @csrf
                        <div class="form-group row">
                            <textarea name="text" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                        <button class="btn btn-primary">Добавить</button>
                    </form>
                </div>
            </div>
        @endif

        @if($word->comments->count())
            @foreach($word->comments as $comment)
                <div class="card mt-2">
                    <div class="card-header">Автор: {{ $comment->user->name }}</div>
                    <div class="card-body">{{ $comment->text  }}</div>
                </div>
            @endforeach
        @endif
    </div>
@stop