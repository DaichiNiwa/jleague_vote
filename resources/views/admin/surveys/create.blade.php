@extends('layouts.admin_default')

@section('title', '新規アンケート登録')

@section('content')
<h1>新規アンケート登録</h1>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ action('admin\SurveysController@store') }}">
            @csrf
            <div class="form-group">
                <label for="question" class="col-form-label">質問文(100文字)</label>
                <textarea rows="3" class="form-control @error('question') is-invalid @enderror" name="question" required autocomplete="question" autofocus>{{ old('question') }}</textarea>
                @error('question')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <p>選択肢は50文字以内で入力してください。</p>

            <div class="form-group">
                <label for="choice1" class="choice1">選択肢①</label>
                <input id="choice1" type="text" class="form-control @error('choice1') is-invalid @enderror" name="choice1" value="{{ old('choice1', 'そう思う。') }}" required>

                @error('choice1')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="choice2" class="choice2">選択肢②</label>
                <input id="choice2" type="text" class="form-control @error('choice2') is-invalid @enderror" name="choice2" value="{{ old('choice2', 'どちらかと言えばそう思う。') }}" required>

                @error('choice1')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="choice3" class="choice3">選択肢③</label>
                <input id="choice3" type="text" class="form-control @error('choice3') is-invalid @enderror" name="choice3" value="{{ old('choice3', 'どちらかと言えばそう思わない。') }}" required>

                @error('choice3')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="choice4" class="choice4">選択肢④</label>
                <input id="choice4" type="text" class="form-control @error('choice4') is-invalid @enderror" name="choice4" value="{{ old('choice4', 'そう思わない。') }}" required>

                @error('choice4')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="choice5" class="choice5">選択肢⑤</label>
                <input id="choice5" type="text" class="form-control @error('choice5') is-invalid @enderror" name="choice5" value="{{ old('choice5', 'どちらとも言えない。わからない。') }}" required>

                @error('choice5')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="close_at">投票締切日（デフォルトでは今日から8日後）</label>
                <div class="input-group row pl-3">
                    <input type="date" id="close_at" name="close_at" class="form-control col-3 @error('close_at') is-invalid @enderror" value="{{ old('close_at', $close_at) }}" required>
                    <div class="input-group-append"><div class="input-group-text">0時0分</div></div>
                    @error('close_at')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            
            <p>新規登録が完了すると同時にTwitterで告知されます。</p>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    新規登録
                </button>
            </div>

        </form>
    </div>
</div>
@endsection