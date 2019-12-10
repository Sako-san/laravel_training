@extends('layout')

@section('content')
    <form method="POST" action="{{ route('posts.store') }}">
        @csrf
        <div>
            <label for="">Title</label>
            <input type="text" name="title">
        </div>

        <div>
            <label for="">Content</label>
            <input type="text" name="content">
        </div>


        <button type="submit">Create!</button>
    </form>
@endsection