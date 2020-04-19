@extends('layouts.default')

@section('title','このサイトについて')

@section('content')
<h2>このサイトについて</h2>
<div class="card">
    <div class="card-body">
        <p>このサイトでは同一ユーザーによる多重投票を防ぐため、クッキーを使用しております。またユーザーの判別のため、IPアドレスを取得しております。これによって個人を特定できるわけではありません。</p>
        <a href="{{ url('/') }}" class="btn btn-secondary">トップページに戻る</a>
    </div>
</div>
@endsection