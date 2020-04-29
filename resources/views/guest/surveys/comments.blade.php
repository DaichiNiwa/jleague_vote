@extends('layouts.default')

@section('title', 'コメント一覧 / Jリーグ勝者予想')

@section('content')

    <h3>コメント一覧</h3>

    @include('guest.layouts.small_survey_card', ['survey' => $survey])

    <div class="d-flex mb-3">
        @if($survey->are_comments_full() === false)
            <a href="{{ action('guest\SurveyCommentsController@create', $survey) }}" class="btn btn-warning mr-3">コメントを書く</a>
        @endif
        @if($survey->is_open() === true)
            <a href="{{ action('guest\SurveysController@show', $survey) }}" class="btn bg-theme-light">投票に戻る</a>
        @else
            <a href="{{ action('guest\SurveysController@show', $survey) }}" class="btn btn-secondary">結果に戻る</a>
        @endif
    </div>
    
    @if($survey->are_comments_full() === true)
        <p>コメント数が上限に達したため、新しいコメントはできません。</p>
    @endif

    @if($survey->comments_amount() > 0)
        {{ $comments->links() }}
        {{ $pagenate_text }}
            <div class="row">
                @include('guest.layouts.survey_comment_card', ['comments' => $comments])
            </div>
        {{ $comments->links() }}
    @else
        <p>まだコメントはありません。</p>
    @endif

@endsection
