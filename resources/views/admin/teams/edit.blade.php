@extends('layouts.admin_default')

@section('title', 'チーム編集')

@section('content')
    <h1>チーム編集</h1>
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header">名前</div>
                <div class="card-body">
                    <p>名前は20文字以内で入力してください。</p>
                    <form method="POST" action="{{ action('admin\TeamsController@update', $team) }}">
                        @csrf
                        @method('PATCH')
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label text-md-right">名前</label>

                            <div class="col-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $team->name) }}" required autocomplete="name">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    名前を更新
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">昨年順位</div>
                <div class="card-body">
                    <form method="POST" action="{{ action('admin\TeamsController@update', $team) }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="form-group row">
                            <label for="ranking" class="col-4 col-form-label text-md-right">昨年順位</label>

                            <div class="col-6">
                                <select name="ranking" id="ranking" class="form-control @error('ranking') is-invalid @enderror">
                                    @for($i = 1; $i <= 20; $i++)
                                    <option value="{{ $i }}" @if($i === $team->ranking) selected @endif>{{ $i }}位</option>
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
                            <div class="col-6 offset-md-4">
                                <button type="submit" class="btn btn-secondary">
                                    昨年順位を更新
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection