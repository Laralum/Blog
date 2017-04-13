{!!
    \ConsoleTVs\Charts\Facades\Charts::multiDatabase('line', 'highcharts')
    ->title(__('laralum_blog::general.latest_blog_comments'))
    ->dataset(__('laralum_blog::general.new_comments'), \Laralum\Blog\Models\Comment::all())
    ->elementLabel(__('laralum_blog::general.new_comments'))->lastByDay(7, true)->render();
!!}
