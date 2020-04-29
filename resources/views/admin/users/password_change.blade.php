@extends('layouts.admin_default')

@section('title', 'パスワード変更')

@section('content')
    <h1>パスワード変更</h1>
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header">パスワード変更</div>

                <div class="card-body">
                    <p>変更する管理者: {{ $user->name }}</p>
                    <p>パスワードは半角英数字で入力してください。</p>

                    <form method="POST" action="{{ action('admin\UsersController@update', $user) }}">
                        @csrf
                        @method('PATCH')
                        <div class="form-group row">
                            <label for="password" class="col-4 col-form-label text-md-right">新しいパスワード</label>

                            <div class="col-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" autofocus>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-4 col-form-label text-md-right">新しいパスワード確認</label>

                            <div class="col-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    変更
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection