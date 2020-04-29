@extends('layouts.default')

@section('title', 'コメントを書く / Jリーグ勝者予想')

@section('content')

    <h3>コメントを書く</h3>

    @include('guest.layouts.small_match_card', ['match' => $match])

    <div class="d-flex mb-3">
        <a href="{{ action('guest\MatchCommentsController@index', $match) }}" class="btn btn-primary mr-3">
            すべてのコメント<span class="badge badge-light">{{ $match->comments_amount() }}</span></a>        
        @if($match->is_open() === true)
            <a href="{{ action('guest\MatchesController@show', $match) }}" class="btn bg-theme-light">投票に戻る</a>
        @else
            <a href="{{ action('guest\MatchesController@show', $match) }}" class="btn btn-secondary">結果に戻る</a>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ action('guest\MatchCommentsController@store', $match) }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="nickname">ニックネーム<small>（自由）</small></label>
                    <input type="text" name="nickname" class="form-control @error('nickname') is-invalid @enderror" id="nickname" value="{{ old('nickname') }}">

                    @error('nickname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <p>あなたの応援するチームは？<small>（必須）</small></p>
                <div class="choice5 mb-3">
                    <div class="custom-control custom-radio">
                        <input id="both" name="voted_to" type="radio" class="custom-control-input" value="2" required @if(old('voted_to') === "2") checked @endif>
                        <label class="custom-control-label" for="both">どちらも応援！</label>
                    </div>
                </div>

                <div class="choice1 mb-3">
                    <div class="custom-control custom-radio">
                        <input id="team1" name="voted_to" type="radio" class="custom-control-input" value="0" @if(old('voted_to') === "0") checked @endif>
                        <label class="custom-control-label" for="team1">{{ $match->team1->name }}を応援！</label>
                    </div>
                </div>

                <div class="choice4 mb-3">
                    <div class="custom-control custom-radio">
                        <input id="team2" name="voted_to" type="radio" class="custom-control-input" value="1" @if(old('voted_to') === "1") checked @endif>
                        <label class="custom-control-label" for="team2">{{ $match->team2->name }}を応援！</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="comment">コメント<small>（必須・300文字以内）</small></label>
                    <textarea name="comment" id="comment" class="form-control @error('comment') is-invalid @enderror" rows="5" required>{{ old('comment') }}</textarea>

                    @error('comment')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <p>投稿したコメントの編集や削除はできません。内容を確認してから投稿してください。</p>
                <button type="submit" class="btn btn-warning">コメントを投稿</button>
            </form>
        </div>
    </div>

@endsection
