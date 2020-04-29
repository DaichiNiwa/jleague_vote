@extends('layouts.default')

@section('title', '検索結果 / Jリーグ勝者予想')

@section('content')

    <h3>検索結果</h3>
    <div class="card mb-4">
        <div class="card-body pb-0">
            <p>チーム①：@isset($team1) {{ $team1->name }} @else キーワード「{{ $keyword1 }}」でチームが見つかりませんでした。@endif</p>
            @isset($keyword2)
                <p>チーム②：@isset($team2) {{ $team2->name }} @else キーワード「{{ $keyword2 }}」でチームが見つかりませんでした。@endif</p>
            @endisset
        </div>
    </div>

    @if(count($matches) > 0) 
        <p>{{ $pagenate_text }}</p>
        {{ $matches->appends(['keyword1' => $keyword1, 'keyword2' => $keyword2])->links() }}
        <div class="row">
            @include('guest.layouts.match_card', ['matches' => $matches])
        </div>
        {{ $matches->appends(['keyword1' => $keyword1, 'keyword2' => $keyword2])->links() }}
    @else
        <p>試合が見つかりませんでした。</p>
    @endif

@endsection
