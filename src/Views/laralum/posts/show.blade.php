@php
    $settings = \Laralum\Blog\Models\Settings::first();
@endphp
@extends('laralum::layouts.master')
@section('icon', 'ion-eye')
@section('title', __('laralum_blog::general.view_post'))
@section('subtitle', __('laralum_blog::general.view_post_desc', ['id' => $post->id]))
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_blog::general.home')</a></li>
        <li><a href="{{ route('laralum::blog.categories.index') }}">@lang('laralum_blog::general.category_list')</a></li>
        <li><a href="{{ route('laralum::blog.categories.show', ['category' => $post->category->id]) }}" >@lang('laralum_blog::general.category_posts')</a></li>
        <li><span>@lang('laralum_blog::general.post_id', ['id' => $post->id])</span></li>
    </ul>
@endsection
@section('content')
<div class="uk-container">
    <div>
        <div class="uk-card uk-card-default">
            <div class="uk-card-media-top uk-overflow-hidden" style="max-height:500px;">
                <img @if($post->image) src="{{ $post->image }}" class="uk-width-1-1" alt="image" @endif>
            </div>
            <div class="uk-card-body">
                <article class="uk-article">
                    <h1 class="uk-article-title"><a class="uk-link-reset" href="">{{ $post->title }}</a></h1>
                    <span class="uk-article-meta">@lang('laralum_blog::general.written_by', ['username' => $post->user->name, 'time_ago' => $post->created_at->diffForHumans(), 'cat' => $post->category->name])</span>
                    @if ($post->public)
                        <span class="uk-label uk-label-success">@lang('laralum_blog::general.published')</span>
                    @else
                        <span class="uk-label uk-label-warning">@lang('laralum_blog::general.unpublished')</span>
                    @endif
                    <br>
                    <p>{!! $post->content !!}</p>
                    <br>
                    <div class="uk-grid-small uk-child-width-1-2@s uk-margin-small-top" uk-grid>
                        <div class="uk-margin-top">
                            @if ($settings->comments_system == 'laralum')
                                <a class="uk-button uk-button-text uk-align-center uk-align-left@s uk-button" href="#comments"  uk-scroll>{{ trans_choice('laralum_blog::general.comments_choice', $post->comments->count(), ['num' => $post->comments->count()]) }}</a>
                            @endif
                        </div>
                        <span class="uk-margin-top">
                            @can('delete', $post)
                                <a class="uk-button uk-button-text uk-align-left uk-align-right@s" href="{{ route('laralum::blog.posts.destroy.confirm', ['post' => $post->id]) }}">@lang('laralum_blog::general.delete_post')</a>
                            @endcan
                            @can('update', $post)
                                <a class="uk-button uk-button-text uk-align-right uk-align-right@s" href="{{ route('laralum::blog.posts.edit', ['post' => $post->id]) }}">@lang('laralum_blog::general.edit_post')</a>
                            @endcan
                        </span>
                    </div>
                </article>
            </div>
        </div>
    </div>
    <br><br><br>
    @if (\Auth::user()->can('access', \Laralum\Blog\Models\Comment::class) && $settings->comments_system == 'laralum')
        <div id="comments">
            <div class="uk-card uk-card-default uk-card-body">
                <h3 class="uk-card-title">@if($post->comments->count()) @lang('laralum_blog::general.comments') @else @lang('laralum_blog::general.no_comments_yet') @endif</h3>
                @foreach ($post->comments as $comment)
                    @can('view', $comment)
                        <article class="uk-comment uk-comment-primary">
                            <header class="uk-comment-header uk-grid-medium uk-flex-middle" uk-grid>

                                <div class="uk-width-auto">
                                    <img class="uk-comment-avatar uk-border-circle" src="{{ $comment->user->avatar() }}" width="80" height="80" alt="">
                                </div>
                                <div class="uk-width-expand">
                                    <h4 class="uk-comment-title uk-margin-remove"><span>{{ $comment->user->name }}</span></h4>
                                    <ul class="uk-comment-meta uk-subnav uk-subnav-divider uk-margin-remove-top">
                                        <li><span>{{ $comment->created_at->diffForHumans() }}</span></li>
                                    </ul>
                                </div>
                            </header>
                            <div class="uk-comment-body">
                                @can('delete', $comment)
                                    <a class="uk-button uk-button-text uk-align-right" href="{{ route('laralum::blog.comments.destroy.confirm',['comment' => $comment->id ]) }}"><i style="font-size:18px;" class="icon ion-trash-b"></i> @lang('laralum_blog::general.delete')</a>
                                @endcan
                                @can('update', $comment)
                                    <button class="uk-button uk-button-text uk-align-right edit-comment-button" data-url="{{ route('laralum::blog.comments.update',['comment' => $comment->id ]) }}"><i style="font-size:18px;" class="icon ion-edit"></i> @lang('laralum_blog::general.edit')</button>
                                @endcan
                                <p class="comment-box uk-text-nowrap">{{ $comment->comment }}</p>
                            </div>
                        </article>
                        <br>
                    @endcan
                @endforeach
                @can('create', \Laralum\Blog\Models\Comment::class)
                <article class="uk-comment uk-comment-primary">
                    <header class="uk-comment-header uk-grid-medium uk-flex-middle" uk-grid>
                        <div class="uk-width-auto">
                            <img class="uk-comment-avatar uk-border-circle" src="{{ \Laralum\Users\Models\User::findOrFail(Auth::id())->avatar() }}" width="80" height="80" alt="">
                        </div>
                        <div class="uk-width-expand">
                            <h4 class="uk-comment-title uk-margin-remove"><span>{{ \Laralum\Users\Models\User::findOrFail(Auth::id())->name }}</span></h4>
                        </div>
                    </header>

                    <div class="uk-comment-body">

                        <form class="uk-form-stacked" method="POST" action="{{ route('laralum::blog.comments.store',['post' => $post->id]) }}">
                            {{ csrf_field() }}
                            <fieldset class="uk-fieldset">
                                <div class="uk-margin">
                                    <textarea name="comment" class="uk-textarea" rows="8" placeholder="{{ __('laralum_blog::general.add_a_comment') }}">{{ old('comment') }}</textarea>
                                </div>
                                <div class="uk-margin">
                                    <button type="submit" class="uk-button uk-button-primary">
                                        <span class="ion-forward"></span>&nbsp; @lang('laralum_blog::general.submit')
                                    </button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </article>
                @endcan
            </div>
        </div>
        <form class="uk-form-stacked uk-hidden" id="edit-comment-form" method="POST">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <fieldset class="uk-fieldset">
                <div class="uk-margin">
                    <textarea name="comment" class="uk-textarea" id="comment-textarea" rows="8" placeholder="{{ __('laralum_blog::general.edit_a_comment') }}">{{ old('comment') }}</textarea>
                </div>
                <div class="uk-margin">
                    <button type="submit" class="uk-button uk-button-primary">
                        <span class="ion-forward"></span>&nbsp; @lang('laralum_blog::general.submit')
                    </button>
                </div>
            </fieldset>
        </form>
    @elseif ($settings->comments_system == 'disqus')
        <div>
            <div class="uk-card uk-card-default uk-card-body">
                @component('laralum_blog::disqus')
                    {{ \Laralum\Blog\Models\Settings::first()->disqus_website_shortname }}
                @endcomponent
            </div>
        </div>
    @endif
</div>
@endsection
@section('js')
    @if (\Auth::user()->can('access', \Laralum\Blog\Models\Comment::class) && $settings->comments_system == 'laralum')
        <script>
            $(function() {
                $('.edit-comment-button').click(function() {
                    console.log('here1')
                    $('.edit-comment-button').prop('disabled', false);
                    $(this).attr('disabled', 'disabled');
                    var url = $(this).data('url');
                    // var comment = $(this).data('comment');
                    var comment = $(this).next('.comment-box').html();
                    $('#comment-textarea').html(comment);
                    var form = $('#edit-comment-form').html();
                    $('.edit-comment-form').hide();
                    $('.comment').removeClass("uk-hidden"); {{-- Show all comments --}}
                    $(this).next('.comment-box').html('<form class="uk-form-stacked edit-comment-form uk-animation-scale-up" id="edit-comment-form" action="' + url + '" method="POST">' + form + '</form><p class="comment uk-hidden">'+comment+'</p>');
                    console.log(form)
                });
            });
        </script>
    @endif
@endsection
