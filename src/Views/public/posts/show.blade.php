@extends('laralum::layouts.public')
@section('css')
    <style>
        .hidden {
            display: none;
        }
    </style>
@endsection
@section('title', __('laralum_blog::general.view_post'))
@section('content')

                <h1>{{ $post->title }}</h1>

                <p>@lang('laralum_blog::general.written_by', ['username' => $post->user->name, 'time_ago' => $post->created_at->diffForHumans(), 'cat' => $post->category->title])</p>

                <p>{!! $post->content !!}</p>

                <br>
                <div class="uk-grid-small uk-child-width-1-1" uk-grid>
                    <span>
                        <a href="#comments">{{ trans_choice('laralum_blog::general.comments_choice', $post->comments->count(), ['num' => $post->comments->count()]) }}</a>
                    </span>
                </div>

            </article>
        </div>
    </div>
    </div>
    <br><br><br>
    @can('access', \Laralum\Blog\Models\Comment::class)
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
                                    <form action="{{ route('laralum_public::blog.categories.posts.comments.destroy',['category' => $post->category->id, 'post' => $post->id, 'comment' => $comment->id ]) }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" name="button">@lang('laralum_blog::general.delete')</button>
                                    </form>
                                @endcan
                                @can('update', $comment)
                                    <button class="uk-button uk-button-text uk-align-right edit-comment-button" data-comment="{{ $comment->comment }}" data-url="{{ route('laralum_public::blog.categories.posts.comments.update',['category' => $post->category->id, 'post' => $post->id, 'comment' => $comment->id ]) }}">@lang('laralum_blog::general.edit')</button>
                                @endcan
                                <p class="comment">{{ $comment->comment }}</p>
                            </div>
                        </article>
                        <br>
                    @endcan
                @endforeach
                @can('create', \Laralum\Blog\Models\Comment::class)
                            <img src="{{ \Laralum\Users\Models\User::findOrFail(Auth::id())->avatar() }}" width="80" height="80" alt="">
                            <h4><span>{{ \Laralum\Users\Models\User::findOrFail(Auth::id())->name }}</span></h4>
                    <div>
                        <form method="POST" action="{{ route('laralum::blog.categories.posts.comments.store',['category' => $post->category->id, 'post' => $post->id]) }}">
                            {{ csrf_field() }}
                                    <textarea name="comment" class="uk-textarea" rows="8" placeholder="{{ __('laralum_blog::general.add_a_comment') }}">{{ old('comment') }}</textarea>
                                    <button type="submit">@lang('laralum_blog::general.submit')</button>
                        </form>
                    </div>
                @endcan
            </div>
        </div>
        <form class="hidden" id="edit-comment-form" method="POST">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
                    <textarea name="comment" class="uk-textarea" id="comment-textarea" rows="8" placeholder="{{ __('laralum_blog::general.edit_a_comment') }}">{{ old('comment') }}</textarea>
                    <button type="submit" class="uk-button uk-button-primary">@lang('laralum_blog::general.submit')</button>
        </form>
    @endcan
</div>
@endsection
@section('js')
    <script>
        $(function() {
            $('.edit-comment-button').click(function() {
                $('.edit-comment-button').prop('disabled', false);
                $(this).attr('disabled', 'disabled');
                var url = $(this).data('url');
                var comment = $(this).data('comment');
                $('#comment-textarea').html(comment);
                var form = $('#edit-comment-form').html();
                $('.edit-comment-form').hide();
                $('.comment').removeClass("hidden"); {{-- Show all comments --}}
                $(this).next().html('<form class="uk-form-stacked edit-comment-form uk-animation-scale-up" id="edit-comment-form" action="' + url + '" method="POST">' + form + '</form><p class="comment hidden">'+comment+'</p>');
            });
        });
    </script>
@endsection
