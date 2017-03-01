@extends('laralum::layouts.master')
@section('icon', 'ion-edit')
@section('title', __('laralum_blog::general.edit_post'))
@section('subtitle', __('laralum_blog::general.edit_post_desc', ['id' => $post->id, 'time_ago' => $post->created_at->diffForHumans()]))
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_blog::general.home')</a></li>
        <li><a href="{{ route('laralum::blog.categories.index') }}">@lang('laralum_blog::general.category_list')</a></li>
        <li><span>@lang('laralum_blog::general.edit_post')</span></li>
    </ul>
@endsection
@section('content')
    @include('laralum_blog::posts.form', [
        'action' => route('laralum::blog.categories.posts.update', ['category' => $post->category->id, 'post' => $post->id]),
        'button' => __('laralum_blog::general.edit_post'),
        'title' => __('laralum_blog::general.edit_post'),
        'method' => 'PATCH',
        'post' => $post,
        'category' => $post->category,
        'cancel' => route('laralum::blog.categories.posts.show', ['category' => $post->category->id, 'post' => $post->id])
    ])
@endsection
