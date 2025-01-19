@extends('layouts.app')

@section('title', 'Main Page')

@section('content')
<div class="container">
@if(isset($userQuery) && $userQuery)
    <h1>Articles by User: {{ $userQuery }}</h1>
@elseif(isset($articleQuery) && $articleQuery)
    <h1>Articles Containing: {{ $articleQuery }}</h1>
@else
    <h1>All Articles</h1>
@endif



<!-- Search Forms -->
<div class="d-flex justify-content-between mb-4">
    <!-- Search by User -->
    <form method="GET" action="{{ route('articles.searchByUser') }}" class="mr-3">
        <input type="text" name="search" class="form-control mb-2" placeholder="Search by username..." value="{{ $userQuery ?? '' }}">
        <button type="submit" class="btn btn-primary">Search by User</button>
        @if(isset($userQuery) && $userQuery)
            <button type="submit" class="btn btn-secondary ml-2" name="reset" value="1">Reset</button>
        @endif
    </form>

    <!-- Sorting button -->
    <div class="sort-btn">
        <a href="{{ route('articles.sort', ['order' => request('order') === 'asc' ? 'desc' : 'asc']) }}" class="btn btn-primary">
            @if (request('order') === 'asc')
                <i class="fas fa-sort-amount-up"></i> Oldest to Newest
            @else
                <i class="fas fa-sort-amount-down"></i> Newest to Oldest
            @endif
        </a>
    </div>
    
    <!-- Search by Article -->
    <form method="GET" action="{{ route('articles.searchByArticle') }}">
        <input type="text" name="search" class="form-control mb-2" placeholder="Search by article..." value="{{ $articleQuery ?? '' }}">
        <button type="submit" class="btn btn-primary">Search by Article</button>
        @if(isset($articleQuery) && $articleQuery)
            <button type="submit" class="btn btn-secondary ml-2" name="reset" value="1">Reset</button>
        @endif
    </form>

</div>

    @if($articles->isEmpty())
        <h2 class="no-articles">No articles found.</h2>
    @else
        <ul class="article-list">
            @foreach($articles as $article)
                <li class="article-item">
                    <div class="d-flex flex-column justify-content-between">
                        <!-- Image Placeholder-->
                        <i class="fa-solid fa-image"></i>

                        <!-- View Button -->
                        
                        <a href="{{ route('articles.show', $article->id) }}"class="btn btn-primary">View</a>
                        
                        <!-- Edit Button -->
                        @if(auth()->id() === $article->user_id)
                            <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-success">Edit</a>
                        @else
                            <button class="btn btn-secondary" disabled>Edit</button>
                        @endif

                        <!-- Delete Button -->
                        @if(auth()->id() === $article->user_id)
                            <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        @else
                            <button class="btn btn-secondary" disabled>Delete</button>
                        @endif
                        
                    </div>

                    <div class="articles" >
                        <!-- Title -->
                        <a href="{{ route('articles.show', $article->id) }}">{{ $article->title }}</a>
                        <!-- Author -->
                        <p >By: {{ $article->user->name }} <br> {{ $article->created_at->format('d/m/Y') }}</
                        </p>
                        <!-- Contents -->
                        <!-- <p>{{ $article->content }}</p> -->
                    </div>
            
                </li>
            @endforeach
        </ul>
    @endif

    <!-- Create Article Button -->
    <div class="text-center mt-4">
        <a href="{{ route('articles.create') }}" class="btn btn-success btn-lg">Create New Article</a>
    </div>

     <!-- Pagination Links -->
     <div class="pagination-container text-center mt-4">
        {{ $articles->links() }}
    </div>

    <!-- <a href="{{ url('/') }}" class="btn btn-success mt-4">Back to Main</a> -->
</div>


@endsection

@section('styles')
<style>
    /* General Styling */
    body {
        font-family: Arial, sans-serif;
        background-color: #f7f7f7;
        margin: 0;
        padding: 0;
    }

    h1 {
        text-align: center;
        margin-top: 30px;
        color: #333;
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
    
    /* Article List Styling */
    .article-list {
        list-style-type: none;
        padding: 0;
    }

    .article-item {
        padding: 15px;
        border-bottom: 1px solid #ddd;
        margin-bottom: 15px;
        background-color: #ccc;
        border-radius: 5px;
        transition: all 1s ease;
        display: flex;
        justify-content: start;
        align-items: start;
    
    }

    /* .article-item:hover {
        background-color: #f1f1f1;
    } */

    .article-item .articles {
        font-size: 1.1em; 
        margin: 10px;
        display:flex;
        flex-direction: column;
        /* align-items: center; */
        /* justify-content: center; */
        padding: 20px;
        word-break: break-word;
        /* background-color:green; */
    }

    .articles a{
        color: #000;
        font-size: 2rem;
        text-decoration: none;
        
    }
    .articles a:hover{
        color: #fff;
    }
    
    .articles p{
        width:fit-content;
        font-size: 1.2rem;
        margin-top: 30px;
        border-top:5px double black;
    }

    /* Button Styling */
    .btn {
        font-size: 1em;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .sort-btn{
        margin-top: auto;
    }

    /* Disabled Button Styling */
    button.btn[disabled] {
        background-color: #f0f0f0;
        color: #888;
        cursor: not-allowed;
        border: 1px solid #ccc;
    }

    .btn{
        width: 100%;
        margin-bottom: 10px; 
    }
   

    .fa-image{
        max-width: 200px;
        max-height: 200px;
        width: auto;
        height: auto;
        font-size:15rem;
    }

    /* Responsive Styling */
    @media (max-width: 768px) {
        /* Container width */
        .container {
            width: 90%;
        }

        /* Article Item */
        .article-item {
            flex-direction: row;
            align-items: flex-start; /* Align items vertically */
        }

        .article-item p {
            font-size: 0.9em;
        }


        .d-flex {
            flex-direction: column;
        }

        .article-list {
            padding-left: 0; /* Remove default padding on mobile */
        }

        .article-item {
            margin-bottom: 20px; /* Space out article items */
        }
    
    }
    @media (max-width: 600px) {
        .container{
            margin:0 auto;
            padding:0;
        }
        .article-item {
            flex-direction: column;
            align-items: center;
            justify-content: space-between; /* Center items horizontally */
        }


    }

</style>
@endsection
