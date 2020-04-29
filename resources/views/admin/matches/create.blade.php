@extends('layouts.admin_default')

@section('title', '新規試合登録')

@section('content')
<h1>新規試合登録</h1>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ action('admin\MatchesController@confirm') }}">
            @csrf

            <h2 class="border-bottom border-primary">試合内容</h2>
            <div class="form-group">
                <label for="tournament" class="tournament">大会名　</label>
                <select class="parent" name="tournament" class="form-control" required>
                    <option value="" selected>選択</option>
                    <option value="0" @if(old('tournament')==='0' ) selected @endif>J1リーグ</option>
                    <option value="1" @if(old('tournament')==='1' ) selected @endif>天皇杯</option>
                    <option value="2" @if(old('tournament')==='2' ) selected @endif>ルヴァンカップ</option>
                </select>
            </div>

            @include('admin.matches.tournament_sub', ['tournament' => '', 'tournament_sub' => ''])

            <div class="form-check pb-3">
                <input type="hidden" name="homeaway" value="0">
                <input class="form-check-input" type="checkbox" id="homeaway" name="homeaway" value="1" @if(old('homeaway')==='1' ) checked @endif>
                <label class="form-check-label" for="homeaway">ホームアウェイ設定</label>
            </div>

            <p>チーム名はチームを1つに特定できるキーワードを入力してください。（20文字以内）</p>
            <p>（例：浦和、鹿島、マリノス、横浜FC、ヴィッセル、グランパス）</p>

            <div class="form-group">
                <label for="team1_keyword" class="choice1">チーム①（ホームアウェイ設定をした場合、ホームチーム）</label>
                <input id="team1_keyword" type="text" name="team1_keyword" 
                class="form-control @error('team1_keyword') is-invalid @enderror"  value="{{ old('team1_keyword') }}" required>

                @error('team1_keyword')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="team2_keyword" class="choice4">チーム②（ホームアウェイ設定をした場合、アウェイ）</label>
                <input id="team2_keyword" type="text" name="team2_keyword" 
                class="form-control @error('team2_keyword') is-invalid @enderror"  value="{{ old('team2_keyword') }}" required>

                @error('team2_keyword')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="match_date">試合日</label>
                <div class="input-group">
                    <input type="date" id="match_date" name="match_date" 
                    
                    class="form-control col-4 @error('match_date') is-invalid @enderror" value="{{ old('match_date') }}" required>

                    @error('match_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="match_time">試合開始時間</label>
                <div class="input-group">
                    <input type="time" id="match_time" name="match_time" step="1800" min="09:00" max="20:00" 
                    class="form-control col-4 @error('match_time') is-invalid @enderror" value="{{ old('match_time', '10:00') }}" required>

                    @error('match_time')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <h2 class="border-bottom border-primary">設定</h2>

            <div class="form-check pb-3">
                <input type="hidden" name="reserve" value="0">
                <input class="form-check-input" type="checkbox" id="reserve" name="reserve" value="1" @if(old('reserve')==='1' ) checked @endif>
                <label class="form-check-label" id="reserve" for="reserve">予約投稿を設定（チェックすると指定した時間に自動で公開され、試合開始します。）</label>
            </div>

            <div class="form-group">
                <label for="reserve_date">予約投稿日（明日以降）</label>
                <div class="input-group">
                    <input type="date" id="reserve_date" name="reserve_date" 
                    class="form-control col-4 @error('reserve_date') is-invalid @enderror" value="{{ old('reserve_date') }}">

                    @error('reserve_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="reserve_time">予約投稿時間</label>
                <div class="input-group">
                    <input type="time" id="reserve_time" name="reserve_time" step="3600" 
                    class="form-control col-4 @error('reserve_time') is-invalid @enderror" value="{{ old('reserve_time') }}">

                    @error('reserve_time')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>


            <div class="form-check pb-3">
                <input type="hidden" name="focus" value="0">
                <input class="form-check-input" type="checkbox" id="focus" name="focus" value="1" @if(old('focus')==='1' ) checked @endif>
                <label class="form-check-label" for="focus">注目の投票に設定（チェックするとトップページの「注目の投票」で表示されます。）</label>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    確認画面へ
                </button>
            </div>

        </form>
    </div>
</div>
@endsection