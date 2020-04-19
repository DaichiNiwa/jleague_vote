<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-sm navbar-light bg-theme p-4">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">Jリーグ勝者予想</a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="ナビゲーションの切替">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/login') }}">ログイン画面へ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">投票一覧</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">アンケート一覧</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">検索</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="bg-theme p-3">
        <div class="container">
            <div class="row">
                <a href="{{ url('/welcome') }}" class="col-12 col-md-3">このサイトの紹介</a>
                <a href="{{ url('/about') }}" class="col-12 col-md-3">このサイトについて</a>
                <a href="{{ url('/contact') }}" class="col-12 col-md-3">お問い合わせ</a>
            </div>
            <p><small>Copyright &copy; jleague_vote All Rights Reserved.</small></p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>