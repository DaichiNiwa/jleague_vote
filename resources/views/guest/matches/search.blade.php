@extends('layouts.default')

@section('title', 'チーム名で検索 / Jリーグ勝者予想')

@section('content')

    <h3>チーム名で検索</h3>
    <div class="card">
        <div class="card-body">
            <p>チーム名を1つか2つ入力して、試合を検索することができます。</p>
            <p class="m-0">チームを特定できるキーワードを入力してください。</p>
            <p>（例：横浜FC、マリノス、浦和）</p>
            <form action="{{ action('guest\MatchesController@results') }}">
                <div class="form-group">
                    <label for="keyword1">チーム①<small>（必須）</small></label>
                    <input id="keyword1" type="text" name="keyword1" 
                    class="form-control @error('keyword1') is-invalid @enderror"  value="{{ old('keyword1') }}" required>

                    @error('keyword1')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="keyword2">チーム②<small>（自由）</small></label>
                    <input id="keyword2" type="text" name="keyword2" 
                    class="form-control @error('keyword2') is-invalid @enderror"  value="{{ old('keyword2') }}">

                    @error('keyword2')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success"><i class="fas fa-search"></i> 検索</button>
            </form>
        </div>
    </div>
@endsection
