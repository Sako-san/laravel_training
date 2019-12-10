<div>
    <label for="">Title</label>
    <input type="text" name="title" value="{{ old('title', $post->title ?? null) }}">
</div>

<div>
    <label for="">Content</label>
    <input type="text" name="content" value="{{ old('content', $post->content ?? null) }}">
</div>

@if ($errors->any())
    <ul>
        @foreach($errors->all() as $error)
        <LI>{{ $error }}</LI>
        @endforeach
    </ul>
@endif