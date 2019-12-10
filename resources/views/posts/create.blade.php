@extends('layout')

@section('content')
    <form method="POST" action="{{ route('posts.store') }}">
        @csrf
        <div>
            <label for="">Title</label>
            <input type="text" name="title" value="{{ old('title') }}">
        </div>

        <div>
            <label for="">Content</label>
            <input type="text" name="content" value="{{ old('content') }}">
        </div>

        @if ($errors->any())
            <ul>
                @foreach($errors->all() as $error)
                <LI>{{ $error }}</LI>
                @endforeach
            </ul>
        @endif

        <button type="submit">Create!</button>
    </form>
@endsection