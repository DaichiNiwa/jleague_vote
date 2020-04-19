@extends('layouts.default')

@section('title', '投票 / Jリーグ勝者予想')

@section('content')

    @if($match->is_open() === true)
        <h3>投票</h3>
        <div class="card small-card">
            <div class="card-header orange-light">
                <p class="card-text">{{ $match->start_at->isoFormat('Y年M月D日(ddd) H:mm') }}開始</p>
                <h5>{{ $match->tournament_name() . '　' . $match->tournament_sub_name() }}</h5>
            </div>

            <div class="card-body">
                <p>どちらのチームが勝つと思いますか？</p>
                <form method="POST" action="{{ action('admin\TeamsController@store') }}">
                    <div class="d-md-flex justify-content-between">
                        @csrf
                        <div>
                            <div class="team1">
                                <div class="custom-control custom-radio">
                                    <input id="customRadio1" name="customRadio" type="radio" class="custom-control-input align-bottom">
                                    <label class="custom-control-label" for="customRadio1">
                                        {{ $match->team1->name }}
                                        @if($match->is_homeaway_on() === true)<span class="badge badge-home">Home</span>@endif
                                    </label>
                                </div>
                            </div>

                            <div class="team2">
                                <div class="custom-control custom-radio">
                                    <input id="customRadio2" name="customRadio" type="radio" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio2">{{ $match->team2->name }}</label>
                                </div>
                            </div>
                        </div>
                        <a  class="btn bg-theme-light btn-large" href="{{ action('guest\MatchesController@show', $match) }}">投票する</a>
                    </div>
                </form>
            </div>
        </div>
    @endif
        
    <h3>@if($match->is_open() === true) 途中経過 @else 最終結果 @endif</h3>
    <div class="border border-theme rounded-lg bg-white p-3 mb-4">
        @if($match->votes_amount() > 0)
            <div class="d-flex">
                <div class="bg-choice2" style="width: {{ $match->team1_percentage() }}%"></div>
                <div class="bg-choice3" style="width: {{ $match->team2_percentage() }}%"></div>
            </div>
        @else
            <div class="bg-choice5 text-light text-center pt-2">まだ一度も投票されていません。</div>
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
        <form action="{{ action('admin\TeamsController@store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="name"></label>
                <input type="name" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" required>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="subject">お問い合わせの内容</label>
                <select name="subject" class="form-control" required>
                    <option value="不適切なコメントの報告" @if(old('subject') === "不適切なコメントの報告" ) selected @endif>不適切なコメントの報告</option>
                    <option value="試合について" @if(old('subject') === "試合について" ) selected @endif>試合について</option>
                    <option value="アンケートについて" @if(old('subject') === "アンケートについて" ) selected @endif>アンケートについて</option>
                    <option value="サイトの運営について" @if(old('subject') === "サイトの運営について" ) selected @endif>サイトの運営について</option>
                    <option value="その他" @if(old('subject') === "その他" ) selected @endif>その他</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="message">本文（600文字以内）</label>
                <textarea name="message" id="message" class="form-control @error('message') is-invalid @enderror" rows="5" required>{{ old('message') }}</textarea>

                @error('message')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">送信する</button>
        </form>
    </div>
@endsection
