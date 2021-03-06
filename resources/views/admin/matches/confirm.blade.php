@extends('layouts.admin_default')

@section('title', '試合記入確認')

@section('content')
<h1>試合記入確認</h1>
<div class="card">
    <div class="card-body">

        <h2 class="border-bottom border-primary">試合内容</h2>
        
        <div class="row">
            <p class="p-2 col-3 text-center">大会</p>
            <p class="p-2 col-5 alert-success">{{ $match['tournament_name'] }}</p>
        </div>
        <div class="row">
            <p class="p-2 col-3 text-center">大会以下</p>
            @isset($match['tournament_sub_name'])
                <p class="p-2 col-5 alert-success">{{ $match['tournament_sub_name'] }}</p>
            @else
                <p class="p-2 col-5 alert-info">設定なし</p>
            @endisset
        </div>

        <div class="row">
            <p class="p-2 col-3 text-center">ホームアウェイ設定</p>
            @if($match['is_homeaway_on'] === true)
                <p class="p-2 col-5 alert-success">設定あり（チーム①のホームゲーム）</p>
            @else
                <p class="p-2 col-5 alert-info">設定なし</p>
            @endif
        </div>

        <div class="row">
            <p class="p-2 col-3 text-center">チーム①</p>
            @isset($match['team1'])
                <p class="p-2 col-5 alert-success">{{ $match['team1']->name }}</p>
            @else
                <p class="p-2 alert-danger">「{{ $match['team1_keyword'] }}」でチームが見つかりませんでした。</p>
            @endisset
        </div>
        
        <div class="row">
            <p class="p-2 col-3 text-center">チーム②</p>
            @isset($match['team2'])
                <p class="p-2 col-5 alert-success">{{ $match['team2']->name }}</p>
            @else
                <p class="p-2 alert-danger">「{{ $match['team2_keyword'] }}」でチームが見つかりませんでした。</p>
            @endisset
        </div>

        <div class="row">
            <p class="p-2 col-3 text-center">試合日時</p>
            <p class="p-2 col-5 alert-success">{{ $match['start_at']->isoFormat('Y年M月D日(ddd) HH:mm') }}</p>
        </div>            
        
        <h2 class="border-bottom border-primary">設定</h2>
        
        <div class="row">
            <p class="p-2 col-3 text-center">予約投稿</p>
            @isset($match['open_at'])
                <p class="p-2 col-5 alert-success">{{ ($match['open_at'])->isoFormat('Y年M月D日(ddd) HH:mm') }}</p>
            @else
                <p class="p-2 col-5 alert-info">設定なし</p>
            @endisset
        </div>

        <div class="row">
            <p class="p-2 col-3 text-center">注目の投票</p>
            @if($match['is_focus_on'] === true)
                <p class="p-2 col-5 alert-success">設定する</p>
            @else
                <p class="p-2 col-5 alert-info">設定なし</p>
            @endif
        </div>

        <p>記入ミスがないか十分に確認してください。一度公開した試合を予約（公開前）に戻すことはできません。</p>

        @if($match['is_valid_teams'] === true)
            <form method="POST" action="{{ action('admin\MatchesController@store') }}">
                @csrf
                <div class="form-group">
                    @isset($match['open_at'])
                        <p>予約投稿の時間になると自動でTwitterで告知されます。</p>
                        <button type="submit" class="btn btn-primary">
                            この内容で予約投稿する
                        </button>
                    @else
                        <p>公開すると同時に自動でTwitterで告知されます。</p>
                        <button type="submit" class="btn btn-success">
                            この内容で公開する
                        </button>
                    @endisset
                </div>
            </form>
        @else
            <p>チームを修正してください。</p>
        @endif

        <a class="btn btn-secondary" href="{{ action('admin\MatchesController@revise') }}">内容を修正する</a>
    </div>
</div>
@endsection