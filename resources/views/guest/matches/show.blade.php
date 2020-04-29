@extends('layouts.default')

@section('title', '投票 / Jリーグ勝者予想')

@section('content')

@include('guest.layouts.vote_complete')

    @if($is_open === true)
        <h3>投票</h3>
        <div class="card small-card">
            <div class="card-header orange-light">
                <p class="card-text">{{ $match->start_at->isoFormat('Y年M月D日(ddd) H:mm') }}開始</p>
                <h5>{{ $match->tournament_name() . '　' . $match->tournament_sub_name() }}</h5>
            </div>

            <div class="card-body">
                <p>どちらのチームが勝つと思いますか？</p>
                <form method="POST" action="{{ action('guest\MatchVotesController@store', $match) }}">
                    @csrf
                    <div class="d-md-flex justify-content-between">
                        <div>
                            <div class="choice1 mb-3">
                                <div class="custom-control custom-radio">
                                    <input id="team1" name="voted_to" type="radio" class="custom-control-input" value="0" required>
                                    <label class="custom-control-label" for="team1">
                                        {{ $match->team1->name }}
                                        @if($match->is_homeaway_on() === true)<span class="badge badge-home">Home</span>@endif
                                    </label>
                                </div>
                            </div>

                            <div class="choice4 mb-3">
                                <div class="custom-control custom-radio">
                                    <input id="team2" name="voted_to" type="radio" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="team2">{{ $match->team2->name }}</label>
                                </div>
                            </div>
                        </div>
                        @if($has_voted === true)
                            <div>
                                <p class="btn btn-secondary btn-large">投票しました</p>
                                <p class="small m-0">1日1回投票できます。</p>
                            </div>
                        @else
                            <button type="submit" class="btn bg-theme-light btn-large">投票する</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    @endif
    @if($match->is_open() === true && $match->are_votes_full() === true)
        <p>投票数が上限に達したため、投票できません。</p>
    @endif
        
    <div class="d-flex justify-content-between">
        <h3>@if($is_open === true) 途中経過 @else 最終結果 @endif</h3>
        @include('guest.layouts.twitter_link.vote', ['match' => $match])
    </div>
    <div class="border border-theme rounded-lg bg-white p-3 mb-4">
        @if($is_open === false)
            <p>{{ $match->tournament_name() . '　' . $match->tournament_sub_name() . '　' . $match->start_at->isoFormat('Y年M月D日(ddd) H:mm') }}開始</p>
        @endif
        @if($match->votes_amount() > 0)
            <div class="d-flex">
                <div class="bg-choice2 height-3em" style="width: {{ $match->team1_percentage() }}%"></div>
                <div class="bg-choice3 height-3em" style="width: {{ $match->team2_percentage() }}%"></div>
            </div>
        @else
            <div class="bg-choice5 height-3em text-light text-center pt-2">まだ一度も投票されていません。</div>
        @endif
        <div class="d-flex justify-content-between">
            <div>
                <h3 class="py-1 mb-0">{{ $match->team1_percentage() }} %</h3>
                <p class="mt-0">( {{ $match->team1_votes }}票 )</p>
            </div>
            <div>
                <h3 class="py-1 mb-0">{{ $match->team2_percentage() }} %</h3>
                <p class="mt-0 text-right">( {{ $match->team2_votes }}票 )</p>
            </div>
        </div>
        <div class="d-md-flex justify-content-between">
            <p class="choice1">
                {{ $match->team1->name }}
                @if($match->is_homeaway_on() === true)<span class="badge badge-home">Home</span>@endif
            </p>
            <p class="choice4">{{ $match->team2->name }}</p>
        </div>
    </div>
        
    <h3>コメント</h3>
    <div class="border border-primary rounded-lg bg-white p-3">
        @if($match->comments_amount() > 0)
            <div class="row">
                @include('guest.layouts.match_comment_card', ['comments' => $comments])
            </div>
        @else
            <p>まだコメントはありません。</p>
        @endif
        <div class="d-md-flex">
            <p class="m-0"><a href="{{ action('guest\MatchCommentsController@index', $match) }}" class="btn btn-primary mb-3 mb-md-0 mr-md-3">
                すべてのコメント<span class="badge badge-light">{{ $match->comments_amount() }}</span></a>
            </p>
            @if($match->are_comments_full() === true)
                <p>コメント数が上限に達したため、新しいコメントはできません。</p>
            @else
                <p class="m-0"><a href="{{ action('guest\MatchCommentsController@create', $match) }}" class="btn btn-warning">コメントを書く</a></p>
            @endif
        </div>
    </div>


@endsection
