@extends('layouts.admin_default')

@section('title', '管理者用トップ')

@section('content')
    <div>
        <a href="{{ url('/admin/matches/create') }}" class="btn btn-superlg btn-warning">新規試合</a>
        <a href="{{ url('/admin/matches') }}" class="btn btn-superlg btn-warning">試合一覧</a>
    </div>
    <div>
        <a href="{{ url('/admin/surveys/create') }}" class="btn btn-superlg btn-success">新規アンケート</a>
        <a href="{{ url('/admin/surveys') }}" class="btn btn-superlg btn-success">アンケート一覧</a>
    </div>
    <div>
        <a href="{{ url('/admin/teams/create') }}" class="btn btn-superlg btn-primary">新規チーム</a>
        <a href="{{ url('/admin/teams') }}" class="btn btn-superlg btn-primary">チーム一覧</a>
    </div>
    <div>
        <a href="{{ url('/admin/login_records') }}" class="btn btn-superlg btn-info">ログイン履歴</a>
        <a href="{{ url('/admin/notices') }}" class="btn btn-superlg btn-info">お知らせ一覧</a>
    </div>
    @can('is-master-admin')
        <a href="{{ url('/admin/users') }}" class="btn btn-superlg btn-danger">管理者一覧</a>
    @endcan
@endsection
