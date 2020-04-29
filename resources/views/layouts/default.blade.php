<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Twitter Card -->
    @isset($twitter_card)
        @include('layouts.custom_twitter_card', ['twitter_card' => $twitter_card])
    @else
        @include('layouts.default_twitter_card')
    @endisset
    <title>@yield('title')</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-sm navbar-light bg-theme p-4">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">Jリーグ <i class="fas fa-futbol"></i> 勝者予想</a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="ナビゲーションの切替">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/login') }}">ログイン画面へ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/matches') }}">試合一覧</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/surveys') }}">アンケート一覧</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/matches/search') }}">チーム名で検索</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="py-4">
        <div class="container">
            @if(session('warning'))
            <div class="alert alert-danger">
                {{ session('warning') }}
            </div>
            @endif
            @yield('content')
        </div>
    </main>

    <footer class="bg-theme p-3">
        <div class="container">
            <div class="d-md-flex">
                <p class="mb-2 mr-md-5"><a href="{{ url('/welcome') }}">このサイトの紹介</a></p>
                <p class="mb-2 mr-md-5"><a href="{{ url('/about') }}">サイトのご利用について</a></p>
                <p class="mb-2"><a href="{{ url('/contact') }}">お問い合わせ</a></p>
            </div>
            <p><small>Copyright &copy; jleague_vote All Rights Reserved.</small></p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>