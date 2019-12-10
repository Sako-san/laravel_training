@extends('layout')

@section('content')

    @forelse ($posts as $post)
        <p>
            <h3>
                <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
            </h3>

            <a href="{{  route('posts.edit', ['post' => $post->id]) }}">Edit</a>

            <form method="POST" action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                @csrf
                @method('DELETE')
                <button type="submit">Delete!</button>
            </form>
        </p>

    @empty
        <p> No Blog Posts Yet!</p>
    @endforelse
@endsection('content')