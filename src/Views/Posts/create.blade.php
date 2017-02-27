@extends('laralum::layouts.master')
@section('icon', 'ion-plus-round')
@section('title', __('laralum_blog::general.create_post'))
@section('subtitle', __('laralum_blog::general.create_post_desc'))
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_blog::general.home')</a></li>
        <li><a href="{{ route('laralum::blog.categories.index') }}">@lang('laralum_blog::general.category_list')</a></li>
        <li><a href="{{ route('laralum::blog.categories.show', ['category' => $category->id]) }}">@lang('laralum_blog::general.category_posts')</a></li>
        <li><span>@lang('laralum_blog::general.create_post')</span></li>
    </ul>
@endsection
@section('content')
    @include('laralum_blog::posts.form', [
        'action' => route('laralum::blog.categories.posts.store', ['category' => $category->id]),
        'button' => __('laralum_blog::general.create_post'),
        'title' => __('laralum_blog::general.create_post'),
        'cancel' => route('laralum::blog.categories.index')
    ])
@endsection
