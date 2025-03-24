@extends('layouts.main')

@section('content')

<main class="blog">
    <div class="container">
        <h1 class="edica-page-title" data-aos="fade-up">Блог</h1>
        <section class="featured-posts-section">
            <div class="row">
                @foreach($posts as $post)
                <div class="col-md-4 fetured-post blog-post" data-aos="fade-right">
                    <div class="blog-post-thumbnail-wrapper">
                        <img src="{{ 'storage/' . $post->preview_image }}" alt="blog post">
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="blog-post-category">{{ $post->category->title }}</p>
                        @auth()
                        <form action="{{ route('post.like.store', $post->id) }}" method="POST">
                            @csrf
                            <span>{{ $post->liked_users_count }}</span>
                            <button type="submit" class="border-0 bg-transparrent">
                                @if(auth()->user()->LikedPost()->where('post_id', $post->id)->exists())
                                <i class="fas fa-heart"></i>
                                @else
                                <i class="far fa-heart"></i>
                                @endif
                            </button>
                        </form>
                        @endauth
                        @guest()
                        <div>
                            <span>{{ $post->liked_users_count }}</span>
                            <i class="far fa-heart"></i>
                        </div>
                        @endguest
                    </div>
                    <a href="{{route('post.show', $post->id)}}" class="blog-post-permalink">
                        <h6 class="blog-post-title">{{ $post->title }}</h6>
                    </a>
                </div>
                @endforeach
            </div>
        </section>
        <div class="row">
            <div class="col-md-8">
                <section>
                    <div class="row blog-post-row">
                        @foreach($randomPosts as $post)
                        <div class="col-md-6 blog-post" data-aos="fade-up">
                            <div class="blog-post-thumbnail-wrapper">
                                <img src="{{ 'storage/' . $post->preview_image }}" alt="blog post">
                            </div>
                            <p class="blog-post-category">{{ $post->category->title }}</p>
                            <a href="{{route('post.show', $post->id)}}" class="blog-post-permalink">
                                <h6 class="blog-post-title">{{ $post->title }}</h6>
                            </a>
                            @auth()
                            <form action="{{ route('post.like.store', $post->id) }}" method="POST">
                                @csrf
                                <span>{{ $post->liked_users_count }}</span>
                                <button type="submit" class="border-0 bg-transparrent">
                                    @if(auth()->user()->LikedPost()->where('post_id', $post->id)->exists())
                                    <i class="fas fa-heart"></i>
                                    @else
                                    <i class="far fa-heart"></i>
                                    @endif
                                </button>
                            </form>
                            @endauth
                            @guest()
                            <div>
                                <span>{{ $post->liked_users_count }}</span>
                                <i class="far fa-heart"></i>
                            </div>
                            @endguest
                        </div>
                        @endforeach
                    </div>
                </section>
            </div>
            <div class="col-md-4 sidebar" data-aos="fade-left">
                <div class="widget widget-post-list">
                    <h5 class="widget-title">Популярные посты</h5>
                    <ul class="post-list">
                        @foreach($likedPosts as $post)
                        <li class="post">
                            <a href="{{route('post.show', $post->id)}}" class="post-permalink media">
                                <img src="{{ 'storage/' . $post->preview_image }}" alt="blog post">
                                <div class="media-body">
                                    <h6 class="post-title">{{ $post->title }}</h6>
                                </div>
                            </a>
                            @auth()
                            <form action="{{ route('post.like.store', $post->id) }}" method="POST">
                                @csrf
                                <span>{{ $post->liked_users_count }}</span>
                                <button type="submit" class="border-0 bg-transparrent">
                                    @if(auth()->user()->LikedPost()->where('post_id', $post->id)->exists())
                                    <i class="fas fa-heart"></i>
                                    @else
                                    <i class="far fa-heart"></i>
                                    @endif
                                </button>
                            </form>
                            @endauth
                            @guest()
                            <div>
                                <span>{{ $post->liked_users_count }}</span>
                                <i class="far fa-heart"></i>
                            </div>
                            @endguest
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="mx-auto" style="margin-top: -40px; ">
            {{ $posts->links() }}
        </div>
    </div>
    </div>

</main>
@endsection