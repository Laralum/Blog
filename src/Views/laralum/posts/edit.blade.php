@extends('laralum::layouts.master')
@php
    $settings = \Laralum\Blog\Models\Settings::first();
@endphp
@section('icon', 'ion-edit')
@section('title', __('laralum_blog::general.edit_post'))
@section('subtitle', __('laralum_blog::general.edit_post_desc', ['id' => $post->id, 'time_ago' => $post->created_at->diffForHumans()]))
@section('css')
    @if ($settings->text_editor == 'wysiwyg')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.5/tinymce.min.js"></script>
        <script>
            tinymce.init({ selector:'textarea',   plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code'
            ] });
        </script>
    @endif
@endsection
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_blog::general.home')</a></li>
        <li><a href="{{ route('laralum::blog.categories.index') }}">@lang('laralum_blog::general.category_list')</a></li>
        <li><span>@lang('laralum_blog::general.edit_post')</span></li>
    </ul>
@endsection
@section('content')
    <div class="uk-container uk-container-large">
        <div uk-grid>
            <div class="uk-width-1-1@s uk-width-1-5@l"></div>
            <div class="uk-width-1-1@s uk-width-3-5@l">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        {{ __('laralum_blog::general.edit_post') }}
                    </div>
                    <div class="uk-card-body">
                        <form class="uk-form-stacked" method="POST" action="{{ route('laralum::blog.posts.update', ['post' => $post->id]) }}">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <fieldset class="uk-fieldset">
                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_blog::general.title')</label>
                                    <div class="uk-form-controls">
                                        <input value="{{ old('title', $post->title) }}" name="title" class="uk-input" type="text" placeholder="@lang('laralum_blog::general.title')">
                                    </div>
                                </div>
                                <script>
                                    function changeURL() {
                                        $('#image-url').val($('#image-selector').val());
                                    }
                                </script>
                                <select class="uk-select" onchange="changeURL()" id="image-selector">
                                        <option selected>Chose image to set url</option>
                                    @foreach($files as $file)
                                        <option value="{{ route('laralum_public::files.show', ['file' => $file->real_name]) }}">{{ $file->name }}</option>
                                    @endforeach
                                </select>
                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_blog::general.image_url')</label>
                                    <div class="uk-form-controls">
                                        <input value="{{ old('image', $post->image) }}" name="image" class="uk-input" id="image-url" type="text" placeholder="@lang('laralum_blog::general.image_url_ph')">
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_blog::general.description')</label>
                                    <div class="uk-form-controls">
                                        <input value="{{ old('description', $post->description) }}" name="description" class="uk-input" type="text" placeholder="@lang('laralum_blog::general.description')">
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_blog::general.category')</label>
                                    <div class="uk-form-controls">
                                        <select required name="category" class="uk-select">
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" @if($post->category_id == $category->id) selected @endif >
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label">@lang('laralum_blog::general.content')</label>
                                    @if ($settings->text_editor == 'wysiwyg')
                                        <textarea name="content" rows="15">{{ old('content', $post->content) }}</textarea>
                                    @else
                                        @php
                                        $text = old('content', $post->content);
                                        if ($settings->text_editor == 'markdown') {
                                            $converter = new League\HTMLToMarkdown\HtmlConverter();
                                            $text = $converter->convert($text);
                                        }
                                        @endphp
                                        <textarea name="content" class="uk-textarea" rows="15" placeholder="{{ __('laralum_blog::general.content') }}">{{ $text }}</textarea>
                                        @if ($settings->text_editor == 'markdown')
                                            <i>@lang('laralum_blog::general.markdown')</i>
                                        @else
                                            <i>@lang('laralum_blog::general.plain_text')</i>
                                        @endif
                                    @endif
                                </div>

                                <div class="uk-margin">
                                    <input class="uk-hidden" name="public" value="0"/>
                                    <label><input class="uk-checkbox" type="checkbox" name="public" value="1" @can('publish', \Laralum\Blog\Models\Post::class) {{ old('public', $post->public) ? 'checked="checked"' : '' }} @else disabled @endif> @lang('laralum_blog::general.public')</label>
                                </div>

                                <div class="uk-margin">
                                    <a href="{{ route('laralum::blog.categories.show', ['category' => $category->id]) }}" class="uk-button uk-button-default uk-align-left">@lang('laralum_blog::general.cancel')</a>
                                    <button type="submit" class="uk-button uk-button-primary uk-align-right">
                                        <span class="ion-forward"></span>&nbsp; {{ __('laralum_blog::general.edit_post') }}
                                    </button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-1@s uk-width-1-5@l"></div>
        </div>
    </div>
@endsection
