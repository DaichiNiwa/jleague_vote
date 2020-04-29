@extends('layouts.default')

@section('title', 'コメント一覧 / Jリーグ勝者予想')

@section('content')

    <h3>コメント一覧</h3>

    @include('guest.layouts.small_match_card', ['match' => $match])

    <div class="d-flex mb-3">
        @if($match->are_comments_full() === false)
            <a href="{{ action('guest\MatchCommentsController@create', $match) }}" class="btn btn-warning mr-3">コメントを書く</a>
        @endif
        @if($match->is_open() === true)
            <a href="{{ action('guest\MatchesController@show', $match) }}" class="btn bg-theme-light">投票に戻る</a>
        @else
            <a href="{{ action('guest\MatchesController@show', $match) }}" class="btn btn-secondary">結果に戻る</a>
        @endif
    </div>
    
    @if($match->are_comments_full() === true)
        <p>コメント数が上限に達したため、新しいコメントはできません。</p>
    @endif

    @if($match->comments_amount() > 0)
        {{ $comments->links() }}
        {{ $pagenate_text }}
            <div class="row">
                @include('guest.layouts.match_comment_card', ['comments' => $comments])
            </div>
        {{ $comments->links() }}
    @else
        <p>まだコメントはありません。</p>
    @endif

@endsection
