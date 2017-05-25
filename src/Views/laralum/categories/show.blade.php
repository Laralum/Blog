@php
    $settings = \Laralum\Blog\Models\Settings::first();
@endphp
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
@section('css')
    <style>
    .image-parent {
        min-height:350px;
        position: relative;
        overflow: hidden;
    }

    .image-child {
        min-height:350px;
        min-width:100%;
        position: absolute;
        top: -9999px;
        bottom: -9999px;
        left: -9999px;
        right: -9999px;
        margin: auto;
    }

    .description-box {
         resize:none;
         border-color:#FFF;
         height:75px;
    }

    </style>
@endsection
@section('content')
<div class="uk-container uk-container-large">
    <div class="uk-child-width-1-2@m uk-child-width-1-1@s uk-grid-match" uk-grid>
        @if ($posts->count())
            @foreach ($posts as $post)
                <div class="uk-margin-remove">
                    <div class="uk-card uk-card-default uk-margin-medium-bottom">
                        <a href="{{ route('laralum::blog.posts.show', ['post' => $post->id]) }}" class="uk-link-reset">
                            <div class="uk-card-media-top uk-overflow-hidden image-parent">
                                <img src="{{ $post->image ? $post->image : 'https://placeholdit.imgix.net/~text?txtsize=33&txt=Image&w=500&h=250' }}" class="uk-preserve-width image-child" alt="image">
                            </div>
                            <div class="uk-card-header">
                                <div class="uk-grid-small uk-flex-middle" uk-grid>
                                    <div class="uk-width-expand">
                                        <h3 class="uk-card-title uk-margin-remove-bottom">{{ $post->title }}</h3>
                                        <p class="uk-text-meta uk-margin-remove-top"><time>{{ $post->created_at->diffForHumans() }}</time></p>
                                    </div>
                                </div>
                            </div>

                            <div class="uk-card-body uk-panel-scrollable uk-margin-small uk-margin-small-left description-box">
                                {{ $post->description }}
                            </div>
                        </a>
                        <div class="uk-card-footer">
                            <div class="{{($settings->comments_system == 'laralum') ? 'uk-child-width-1-2' : 'uk-child-width-1-1'}} uk-text-center" uk-grid>
                                <div>
                                    @if ($post->public)
                                        <span class="uk-label uk-label-success">@lang('laralum_blog::general.published')</span>
                                    @else
                                        <span class="uk-label uk-label-warning uk-display-inline-block">@lang('laralum_blog::general.unpublished')</span>
                                    @endif
                                </div>
                                @if($settings->comments_system == 'laralum')
                                    <div>
                                        <span class="uk-display-inline">{{ $post->comments->count() }} <i style="font-size:20px;" class="icon ion-chatboxes"></i></span>
                                    </div>
                                @endif

                            </div>
                        </div>
                        <div class="uk-card-footer">
                            <div class="uk-child-width-1-2 uk-text-center" uk-grid>
                                <div><a href="{{ route('laralum::blog.posts.edit', ['post' => $post->id]) }}" class="uk-button uk-button-text">@lang('laralum_blog::general.edit')</a></div>
                                <div><a href="{{ route('laralum::blog.posts.destroy.confirm', ['post' => $post->id]) }}" class="uk-button uk-button-text">@lang('laralum_blog::general.delete')</a></div>
                            </div>
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
