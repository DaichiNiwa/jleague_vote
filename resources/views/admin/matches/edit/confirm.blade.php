@extends('layouts.admin_default')

@section('title', '投票編集記入確認')

@section('content')
<h1>投票編集記入確認</h1>
<div class="card">
    <div class="card-body">

        <h2 class="border-bottom border-primary">試合内容</h2>
        
        <div class="row">
            <p class="p-2 col-3 text-center">大会</p>
            <p class="p-2 col-5 alert-success">{{ $match['tournament_name'] }}</p>
        </div>
        <div class="row">
            <p class="p-2 col-3 text-center">大会以下</p>
            @if(isset($match['tournament_sub_name']))
                <p class="p-2 col-5 alert-success">{{ $match['tournament_sub_name'] }}</p>
            @else
                <p class="p-2 col-5 alert-info">設定なし</p>
            @endif
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
            @if(isset($match['team1']))
                <p class="p-2 col-5 alert-success">{{ $match['team1']->name }}</p>
            @else
                <p class="p-2 alert-danger">「{{ $match['team1_keyword'] }}」でチームが見つかりませんでした。</p>
            @endif
        </div>
        
        <div class="row">
            <p class="p-2 col-3 text-center">チーム②</p>
            @if(isset($match['team2']))
                <p class="p-2 col-5 alert-success">{{ $match['team2']->name }}</p>
            @else
                <p class="p-2 alert-danger">「{{ $match['team2_keyword'] }}」でチームが見つかりませんでした。</p>
            @endif
        </div>

        <div class="row">
            <p class="p-2 col-3 text-center">試合日時</p>
            <p class="p-2 col-5 alert-success">{{ $match['start_at']->isoFormat('Y年M月D日(ddd) HH:mm') }}</p>
        </div>            
        
        <h2 class="border-bottom border-primary">設定</h2>
        
        <div class="row">
            <p class="p-2 col-3 text-center">予約投稿</p>
            @if(isset($match['reserve_at']))
                <p class="p-2 col-5 alert-success">{{ ($match['reserve_at'])->isoFormat('Y年M月D日(ddd) HH:mm') }}</p>
            @else
                <p class="p-2 col-5 alert-info">設定なし</p>
            @endif
        </div>

        <div class="row">
            <p class="p-2 col-3 text-center">注目の投票</p>
            @if($match['is_focus_on'] === true)
                <p class="p-2 col-5 alert-success">設定する</p>
            @else
                <p class="p-2 col-5 alert-info">設定なし</p>
            @endif
        </div>

        <p>記入ミスがないか十分に確認してください。一度公開した投票を予約（公開前）に戻すことはできません。</p>

        @if($match['is_valid_teams'] === true)
            <form method="POST" action="{{ action('admin\MatchesController@update', $match['id']) }}">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    @if(isset($match['reserve_at']))
                        <p>予約投稿の時間になると自動でTwitterで告知されます。</p>
                        <button type="submit" class="btn btn-primary">
                            この内容で予約投稿する
                        </button>
                    @else
                        <button type="submit" class="btn btn-success">
                            この内容で公開する
                        </button>
                    @endif
                </div>
            </form>
        @else
            <p>チームを修正してください。</p>
        @endif

        <a class="btn btn-secondary" href="{{ action('admin\MatchesController@edit_revise') }}">内容を修正する</a>
    </div>
</div>
@endsection