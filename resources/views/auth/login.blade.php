@extends('layouts.default')

@section('title', 'ログイン')

@section('content')
<div class="card">
    <div class="card-header">ログイン</div>
    <div class="card-body">
        <p>管理者ページはPCから閲覧されることを想定しています。（ブラウザはChromeを推奨しています。）スマホやタブレットの場合、レイアウトが崩れる場合があります。</p>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group d-flex">
                <label for="name" class="my-2 mr-4">ログインID</label>
                <div>
                    <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group d-flex">
                <label for="password" class="my-2 mr-4">パスワード</label>
                <div>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                ログイン
            </button>
        </form>
        <p class="mt-4">権限の強い主管理者としてログインする場合、ログインID「user1」、パスワード「password」を入力してください。</p>
        <p>通常の管理者としてログインする場合、ログインID「user2」、パスワード「password」を入力するか、主管理者としてログインしてから、新しい管理者を作成し、その管理者でログインしてください。</p>
    </div>
</div>
@endsection
