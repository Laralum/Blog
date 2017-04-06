@extends('laralum::layouts.public')
@section('title', __('laralum_blog::general.category_posts'))
@section('content')
<div>
        @if ($category->posts->count())
            @foreach ($category->posts as $post)
                <div>
                    <h3>{{ $post->title }}</h3>
                    <p><time datetime="2016-04-01T19:00">{{ $post->created_at->diffForHumans() }}</time></p>
                    <p>{{ $post->description }}</p>
                    <a href="{{ route('laralum_public::blog.categories.posts.show', ['category' => $category->id, 'post' => $post->id]) }}" >@lang('laralum_blog::general.view_post')</a>
                    <span>{{ trans_choice('laralum_blog::general.comments_choice', $post->comments->count(), ['num' => $post->comments->count()]) }}</span>
                </div>
            @endforeach
        @else
            <div class="uk-width-1-1">
                <div class="uk-card uk-card-default uk-card-body">
                    <div uk-alert>
                        <p>@lang('laralum_blog::general.no_posts_yet')</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
