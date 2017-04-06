@extends('laralum::layouts.public')
@section('title', __('laralum_blog::general.category_list'))
@section('content')
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>@lang('laralum_blog::general.name')</th>
            <th>@lang('laralum_blog::general.actions')</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>
                        <a href="{{ route('laralum_public::blog.categories.show', ['category' => $category->id]) }}">
                            @lang('laralum_blog::general.view')
                        </a>
                </td>
            </tr>
        @empty
            <tr>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
