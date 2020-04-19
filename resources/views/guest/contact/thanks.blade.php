@extends('layouts.default')

@section('title','送信完了')

@section('content')
<h2>送信完了</h2>
<div class="card">
    <div class="card-body">
        <p>お問い合わせをいただきありがとうございました。自動返信メールを送信いたしましたのでご確認ください。</p>
        <p>お問い合わせ内容によっては、管理者から別途ご連絡を差し上げる場合がございます。</p>
        <a href="{{ url('/') }}" class="btn btn-secondary">トップページに戻る</a>
    </div>
</div>
@endsection