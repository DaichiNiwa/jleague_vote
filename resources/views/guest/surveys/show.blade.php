@extends('layouts.default')

@section('title', 'アンケート / Jリーグ勝者予想')

@section('content')

@include('guest.layouts.survey_vote_complete')

    @if($is_open === true)
        <h3>アンケート</h3>
        <div class="card small-card">
            <div class="card-header blue-light">
                <p class="card-text">締切：{{ $survey->close_at->isoFormat('Y年M月D日(ddd) H:mm') }}</p>
                <h5>{{ $survey->question }}</h5>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ action('guest\SurveyVotesController@store', $survey) }}">
                    @csrf
                    <div class="d-md-flex justify-content-between">
                        <div>
                            <div class="choice1 mb-3">
                                <div class="custom-control custom-radio">
                                    <input id="choice1" name="voted_to" type="radio" class="custom-control-input" value="1" required>
                                    <label class="custom-control-label" for="choice1">
                                        {{ $survey->choice1 }}
                                    </label>
                                </div>
                            </div>

                            <div class="choice2 mb-3">
                                <div class="custom-control custom-radio">
                                    <input id="choice2" name="voted_to" type="radio" class="custom-control-input" value="2">
                                    <label class="custom-control-label" for="choice2">
                                        {{ $survey->choice2 }}
                                    </label>
                                </div>
                            </div>

                            <div class="choice3 mb-3">
                                <div class="custom-control custom-radio">
                                    <input id="choice3" name="voted_to" type="radio" class="custom-control-input" value="3">
                                    <label class="custom-control-label" for="choice3">
                                        {{ $survey->choice3 }}
                                    </label>
                                </div>
                            </div>

                            <div class="choice4 mb-3">
                                <div class="custom-control custom-radio">
                                    <input id="choice4" name="voted_to" type="radio" class="custom-control-input" value="4">
                                    <label class="custom-control-label" for="choice4">
                                        {{ $survey->choice4 }}
                                    </label>
                                </div>
                            </div>

                            <div class="choice5 mb-3">
                                <div class="custom-control custom-radio">
                                    <input id="choice5" name="voted_to" type="radio" class="custom-control-input" value="5">
                                    <label class="custom-control-label" for="choice5">
                                        {{ $survey->choice5 }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        @if($has_voted === true)
                            <div>
                                <p class="btn btn-secondary btn-large">投票しました</p>
                                <p class="small m-0">アンケートは1人1回、投票できます。</p>
                            </div>
                        @else
                            <button type="submit" class="btn bg-theme-light btn-large">投票する</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    @endif
    @if($survey->is_open() === true && $survey->are_votes_full() === true)
        <p>投票数が上限に達したため、投票できません。</p>
    @endif
        
    <div class="d-flex justify-content-between">
        <h3>@if($is_open === true) 途中経過 @else 最終結果 @endif</h3>
        @include('guest.layouts.twitter_link.survey_vote', ['survey' => $survey])
    </div>
    <div class="border border-theme rounded-lg bg-white p-3 mb-4">
        @if($is_open === false)
            <p>締切：{{ $survey->close_at->isoFormat('Y年M月D日(ddd) H:mm') }}</p>
            <h5>{{ $survey->question }}</h5>
        @endif
        @if($survey->votes_amount() > 0)
            <div class="d-flex">
                <div class="bg-choice1 height-3em" style="width: {{ $survey->choice1_percentage() }}%"></div>
                <div class="bg-choice2 height-3em" style="width: {{ $survey->choice2_percentage() }}%"></div>
                <div class="bg-choice3 height-3em" style="width: {{ $survey->choice3_percentage() }}%"></div>
                <div class="bg-choice4 height-3em" style="width: {{ $survey->choice4_percentage() }}%"></div>
                <div class="bg-choice5 height-3em" style="width: {{ $survey->choice5_percentage() }}%"></div>
            </div>
        @else
            <div class="bg-choice5 height-3em text-light text-center pt-2">まだ一度も投票されていません。</div>
        @endif
        <div class="row justify-content-between mt-4">
            <div class="col-12 col-md-6">
                <div class="row justify-content-between px-2">
                    <p class="choice1 col-8">{{ $survey->choice1 }}</p>
                    <p class="col-4 py-1 px-0"><strong>{{ $survey->choice1_percentage() }} %</strong>（{{ $survey->choice1_amount() }}票）</p>
                </div>
                <div class="row justify-content-between px-2">
                    <p class="choice2 col-8">{{ $survey->choice2 }}</p>
                    <p class="col-4 py-1 px-0"><strong>{{ $survey->choice2_percentage() }} %</strong>（{{ $survey->choice2_amount() }}票）</p>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="row justify-content-between px-2">
                    <p class="choice3 col-8">{{ $survey->choice3 }}</p>
                    <p class="col-4 py-1 px-0"><strong>{{ $survey->choice3_percentage() }} %</strong>（{{ $survey->choice3_amount() }}票）</p>
                </div>
                <div class="row justify-content-between px-2">
                    <p class="choice4 col-8">{{ $survey->choice4 }}</p>
                    <p class="col-4 py-1 px-0"><strong>{{ $survey->choice4_percentage() }} %</strong>（{{ $survey->choice4_amount() }}票）</p>
                </div>
                <div class="row justify-content-between px-2">
                    <p class="choice5 col-8">{{ $survey->choice5 }}</p>
                    <p class="col-4 py-1 px-0"><strong>{{ $survey->choice5_percentage() }} %</strong>（{{ $survey->choice5_amount() }}票）</p>
                </div>
            </div>
        </div>
    </div>
        
    <h3>コメント</h3>
    <div class="border border-primary rounded-lg bg-white p-3">
        @if($survey->comments_amount() > 0)
            <div class="row">
                @include('guest.layouts.survey_comment_card', ['comments' => $comments])
            </div>
        @else
            <p>まだコメントはありません。</p>
        @endif
        <div class="d-md-flex">
            <p class="m-0"><a href="{{ action('guest\SurveyCommentsController@index', $survey) }}" class="btn btn-primary mb-3 mb-md-0 mr-md-3">
                すべてのコメント<span class="badge badge-light">{{ $survey->comments_amount() }}</span></a>
            </p>
            @if($survey->are_comments_full() === true)
                <p>コメント数が上限に達したため、新しいコメントはできません。</p>
            @else
                <p class="m-0"><a href="{{ action('guest\SurveyCommentsController@create', $survey) }}" class="btn btn-warning">コメントを書く</a></p>
            @endif
        </div>
    </div>

@endsection
