@extends('layouts.default')

@section('title', 'Jリーグ勝者予想')

@section('content')

    @if(count($today_matches) > 0)
        <h3>本日の試合</h3>
        <div class="row">
            @include('guest.layouts.match_card', ['matches' => $today_matches])
        </div>
    @endif

    @if(count($notices) > 0)
        <h3 class="headning-mt">お知らせ</h3>
        <div class="border border-primary rounded-lg bg-white p-3">
            @foreach($notices as $notice)
                <p class="small">{{ $notice->created_at->isoFormat('Y年M月D日(ddd)') }}</p>
                <p class="mb-0">{{ $notice->body }}</p>
            @endforeach
        </div>
    @endif

    <h3 class="headning-mt">注目の投票</h3>
    <div class="border border-theme rounded-lg bg-white pt-4">
        @include('guest.layouts.survey_card', ['surveys' => $surveys])
        <div class="row">
            @include('guest.layouts.match_card', ['matches' => $focus_matches])
        </div>
    </div>

    <h3 class="headning-mt">今週の試合</h3>
    <div class="row">
        @include('guest.layouts.match_card', ['matches' => $weekly_matches])
    </div>

@endsection
