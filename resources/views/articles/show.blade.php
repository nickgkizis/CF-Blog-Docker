@extends('layouts.app')

@section('title', 'Main Page')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 2em;
            color: #333;
        }

        .article-content {
            font-size: 1.1em;
            color: #555;
            margin-top: 20px;
            line-height: 1.6;
        }

        .author {
            font-size: 1em;
            color: #777;
            margin-top: 15px;
            font-style: italic;
        }

        .back-link {
            display: inline-block;
            margin-top: 30px;
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>{{ $article->title }}</h2>
        <div class="article-content">
            <p>{{ $article->content }}</p>
        </div>
        <p class="author">By: {{ $article->user->name }}</p>

        <a href="{{ route('articles.index') }}" class="back-link">Back to Articles</a>
    </div>

</body>
</html>
@endsection