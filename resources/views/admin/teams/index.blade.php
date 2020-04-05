@extends('layouts.admin_default')

@section('title', 'チーム一覧')

@section('content')
    <h1>チーム一覧</h1>
    {{ $teams->links() }}
    <table class="table table-striped">
        <tr class="row">
            <th class="col-2">昨年順位</th>
            <th class="col-6">名前</th>
            <th class="col-3">更新日時</th>
            <th class="col-1">編集</th>
        </tr>
        @foreach($teams as $team)
            <tr class="row">
                <td class="col-2">{{ $team->ranking }}位</td>
                <td class="col-6">{{ $team->name }}</td>
                <td class="col-3">{{ $team->updated_at }}</td>
                <td class="col-1">
                    <a href="{{ action('admin\TeamsController@edit', $team) }}" class="btn btn-primary">編集</a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection