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
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-sm navbar-light theme-bgcoloer">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/admin') }}">Jリーグ勝者予想</a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="ナビゲーションの切替">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/admin/matches/create') }}">新規投票</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/admin/matches') }}">投票一覧</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/admin/surveys/create') }}">新規アンケート</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/admin/surveys') }}">アンケート一覧</a>
                        </li>
                        <li class="nav-item">
                            <p class="nav-link mb-0">ログイン中:{{ Auth::user()->name }}</p>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="btn btn-primary" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                ログアウト
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="py-4">
        <div class="container">
            @if(session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endif
            @yield('content')
        </div>
    </main>

    <footer class="theme-bgcoloer">
        <div class="container text-center">
            <div class="">
                <a href="#" class="mr-3 ml-3">このサイトについて</a>
                <a href="#" class="mr-3 ml-3">お問い合わせ</a>
            </div>
            <p><small>Copyright &copy; jleague_vote All Rights Reserved.</small></p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/selectbox.js') }}" defer></script>
</body>

</html>