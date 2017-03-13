@extends('laralum::layouts.master')
@section('icon', 'ion-plus-round')
@section('title', __('laralum_blog::general.create_category'))
@section('subtitle', __('laralum_blog::general.create_category_desc'))
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_blog::general.home')</a></li>
        <li><a href="{{ route('laralum::blog.categories.index') }}">@lang('laralum_blog::general.category_list')</a></li>
        <li><span>@lang('laralum_blog::general.create_category')</span></li>
    </ul>
@endsection
@section('content')
    @include('laralum_blog::categories.form', [
        'action' => route('laralum::blog.categories.store'),
        'button' => __('laralum_blog::general.create_category'),
        'title' => __('laralum_blog::general.create_category'),
        'cancel' => route('laralum::blog.categories.index')
    ])
@endsection
