@extends('laralum::layouts.master')
@section('icon', 'ion-stop')
@section('title', __('laralum_blog::general.category_posts'))
@section('subtitle', __('laralum_blog::general.category_desc', ['id' => $category->id]))
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_blog::general.home')</a></li>
        <li><a href="{{ route('laralum::blog.categories.index') }}">@lang('laralum_blog::general.category_list')</a></li>
        <li><span>@lang('laralum_blog::general.category_posts')</span></li>
    </ul>
@endsection
@section('content')
<div class="uk-container uk-container-large">
    <div class="uk-child-width-1-2@m uk-child-width-1-1@s uk-grid-match" uk-grid>
        @if ($posts->count())
            @foreach ($posts as $post)
                <div>
                    <div class="uk-card uk-card-default">
                        <div class="uk-card-media-top">
                            <img src="{{ $post->image }}" alt="">
                        </div>
                        <div class="uk-card-header">
                            <div class="uk-grid-small uk-flex-middle" uk-grid>
                                <div class="uk-width-expand">
                                    <h3 class="uk-card-title uk-margin-remove-bottom">{{ $post->title }}</h3>
                                    <p class="uk-text-meta uk-margin-remove-top"><time datetime="2016-04-01T19:00">{{ $post->created_at->diffForHumans() }}</time></p>
                                </div>
                            </div>
                        </div>
                        <div class="uk-card-body">
                            <p>{{ $post->description }}</p>
                        </div>
                        <div class="uk-card-footer">
                            <a href="{{ route('laralum::blog.posts.show', ['post' => $post->id]) }}" class="uk-button uk-button-text">@lang('laralum_blog::general.view_post')</a>
                            <span class="uk-align-right">{{ $post->comments->count() }} <i style="font-size:20px;" class="icon ion-chatboxes"></i></span>
                        </div>
                    </div>
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
    @include('laralum::layouts.pagination', ['paginator' => $posts])
</div>
@endsection
