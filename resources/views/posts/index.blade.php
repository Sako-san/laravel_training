@extends('layout')

@section('content')

    @forelse ($posts as $post)
        <p>
            <h3>
                <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
            </h3>

            <p>
                Added {{ $post->created_at->diffForHumans() }}
                by {{ $post->user->name}}
            </p>

            @if($post->comments_count)
                <p>{{ $post->comments_count }} Comments</p>
            @else
                <p>No comments yet!</p>
            @endif

            @can('update', $post)
                <a href="{{  route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
            @endcan 

            <!-- @cannot('delete', $post)
                <p>You can't delete this post</p>
            @endcannot -->

            @can('delete', $post)
            <form method="POST" action="{{ route('posts.destroy', ['post' => $post->id]) }}" class="fm-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-primary" type="submit">Delete!</button>
            </form>
            @endcan
        </p>

    @empty
        <p> No Blog Posts Yet!</p>
    @endforelse
@endsection('content')