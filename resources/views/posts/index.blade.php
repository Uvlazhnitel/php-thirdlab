<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Blog page</title>
</head>
<body>
<h1>Welcome to the programming blog</h1>
<p><a href="{{ route('posts.create') }}">Create new blog post</a></p>

 @foreach ($posts as $post)
<h2><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></h2
<p>An article by <em>{{$post->author}}</em> published on {{$post->created_at
<p>{{ $post->body }}</p>
<!-- edit button -->
<p><a href="{{ route('posts.edit', $post->id) }}" class="btn btn-default">Edit post</a></p>

<!-- delete -->
<p>
        <form method="POST" action="{{ route('posts.destroy', $post->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit">Delete post</button>
        </form>
    </p>

 @endforeach
</body>
</html>