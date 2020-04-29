@extends('layouts.default')

@section('title', 'コメントを書く / Jリーグ勝者予想')

@section('content')

    <h3>コメントを書く</h3>

    @include('guest.layouts.small_survey_card', ['survey' => $survey])

    <div class="d-flex mb-3">
        <a href="{{ action('guest\SurveyCommentsController@index', $survey) }}" class="btn btn-primary mr-3">
            すべてのコメント<span class="badge badge-light">{{ $survey->comments_amount() }}</span></a>        
        @if($survey->is_open() === true)
            <a href="{{ action('guest\SurveysController@show', $survey) }}" class="btn bg-theme-light">投票に戻る</a>
        @else
            <a href="{{ action('guest\SurveysController@show', $survey) }}" class="btn btn-secondary">結果に戻る</a>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ action('guest\SurveyCommentsController@store', $survey) }}" method="post">
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

                <p class="mb-0">{{ $survey->question }}</p>
                <small>（必須・投票にはカウントされません。）</small>
                
                <div class="choice1 mt-3 mb-3">
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
