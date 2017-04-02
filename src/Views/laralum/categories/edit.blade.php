@extends('laralum::layouts.master')
@section('icon', 'ion-edit')
@section('title', __('laralum_blog::general.edit_category'))
@section('subtitle', __('laralum_blog::general.edit_category_desc', ['id' => $category->id, 'time_ago' => $category->created_at->diffForHumans()]))
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_blog::general.home')</a></li>
        <li><a href="{{ route('laralum::blog.categories.index') }}">@lang('laralum_blog::general.category_list')</a></li>
        <li><span>@lang('laralum_blog::general.edit_category')</span></li>
    </ul>
@endsection
@section('content')
    @include('laralum_blog::laralum.categories.form', [
        'action' => route('laralum::blog.categories.update', ['category' => $category->id]),
        'button' => __('laralum_blog::general.edit_category'),
        'title' => __('laralum_blog::general.create_category'),
        'method' => 'PATCH',
        'category' => $category,
        'cancel' => route('laralum::blog.categories.index')
    ])
@endsection
