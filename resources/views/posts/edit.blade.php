@extends('layout')

@section('content')
    <form method="POST" action="{{ route('posts.update', ['post' => $post->id]) }}">
        @csrf
        @method('PUT')

        <div>
            <label for="">Title</label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}">
        </div>

        <div>
            <label for="">Content</label>
            <input type="text" name="content" value="{{ old('content', $post->content) }}">
        </div>

        @if ($errors->any())
            <ul>
                @foreach($errors->all() as $error)
                <LI>{{ $error }}</LI>
                @endforeach
            </ul>
        @endif

        <button type="submit">Update!</button>
    </form>
@endsection