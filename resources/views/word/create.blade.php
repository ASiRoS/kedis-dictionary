@extends('layouts.app')

@section('content')
    <div class="container col-md-10">
        @include('layouts.errors')
        <form action="{{ route('words.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="text" name="title" class="form-control" value="{{ old('title') }}">
            </div>
            <div class="form-group">
                <textarea name="description" id="" class="form-control" cols="30" rows="10">{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
                <input type="file" accept="image/*" name="image">
            </div>
            <button class="btn btn-primary">Добавить слово</button>
        </form>
    </div>
@stop