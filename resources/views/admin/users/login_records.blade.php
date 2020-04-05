@extends('layouts.admin_default')

@section('title', 'ログイン履歴')

@section('content')
    <h1>ログイン履歴</h1>
    {{ $login_records->links() }}
    <table class="table table-striped">
        <tr>
            <th>番号</th>
            <th>ログインユーザー</th>
            <th>IPアドレス</th>
            <th>ログイン日時</th>
        </tr>
        @foreach($login_records as $login_record)
            <tr>
                <td>{{ $login_record->id }}</td>
                <td>
                    @if(isset($login_record->user))
                        {{ $login_record->user->name }}
                    @else
                        ID:{{ $login_record->user_id }}（削除済）
                    @endif
                </td>
                <td>{{ $login_record->ip }}</td>
                <td>{{ $login_record->created_at }}</td>
            </tr>
        @endforeach
    </table>
@endsection