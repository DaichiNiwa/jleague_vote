@extends('layouts.admin_default')

@section('title', '管理者一覧')

@section('content')
    <h1>管理者一覧</h1>
    <table class="table table-striped col-8">
        <tr>
            <th>番号</th>
            <th>ログインユーザー</th>
            <th>パスワード変更</th>
            <th>削除</th>
        </tr>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td><a href="{{ action('admin\UsersController@edit', $user) }}" class="btn btn-primary">パスワード変更</a></td>
                <td>
                    <form method="POST" action="{{ action('admin\UsersController@destroy', $user) }}">
                        @csrf
                        @method('DELETE')
                        <div class="form-group">
                            <div class="">
                                <button type="submit" class="btn btn-danger delete">削除</button>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">新規登録</div>

                <div class="card-body">
                    <p>ログインIDとパスワードは半角英数字で入力してください。</p>
                    <form method="POST" action="{{ action('admin\UsersController@store') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">ログインID</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">パスワード確認</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
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

    <script>
        $('.delete').on('click', () => confirm('本当に削除しますか？'));
    </script>
@endsection