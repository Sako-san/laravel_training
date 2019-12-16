@extends('layout')

@section('content')

    @forelse ($posts as $post)
        <p>
            <h3>
                <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
            </h3>

            @if($post->comments_count)
                <p>{{ $post->comments_count }} Comments</p>
            @else
                <p>No comments yet!</p>
            @endif

            <a href="{{  route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>

            <form method="POST" action="{{ route('posts.destroy', ['post' => $post->id]) }}" class="fm-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-primary" type="submit">Delete!</button>
            </form>
        </p>

    @empty
        <p> No Blog Posts Yet!</p>
    @endforelse
@endsection('content')