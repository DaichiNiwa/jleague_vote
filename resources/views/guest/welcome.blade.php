@extends('layouts.default')

@section('title','このサイトについて')

@section('content')
<h2>Jリーグ勝者予想の紹介</h2>
<div class="card">
    <div class="card-body">
        <p>Jリーグ勝者予想にようこそ。このサイトはゲスト用ページと管理者用ページの2つに分かれています。</p>
        <a href="{{ url('/') }}" class="btn btn-superlg btn-primary">ゲスト用ページへ</a>
        <a href="{{ url('/login') }}" class="btn btn-superlg btn-success">管理者用ページへ</a>
        <p class=""><a href="#" class="btn btn-secondary mt-2 ml-2">ポートフォリオサイトへ戻る</a></p>
    </div>
</div>
@endsection