@extends('layouts.admin_default')

@section('title', '新規チーム登録')

@section('content')
    <h1>新規チーム登録</h1>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <p>名前は20文字以内で入力してください。</p>
                    <form method="POST" action="{{ action('admin\TeamsController@store') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">名前</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ranking" class="col-md-4 col-form-label text-md-right">昨年順位</label>

                            <div class="col-md-6">
                                <select name="ranking" id="ranking" class="form-control @error('ranking') is-invalid @enderror">
                                <option value="">選択してください。</option>
                                    @for($i = 1; $i <= 20; $i++)
                                    <option value="{{ $i }}">{{ $i }}位</option>
                                    @endfor
                                </select>
                                
                                @error('ranking')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    新規登録
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection