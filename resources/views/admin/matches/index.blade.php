@extends('layouts.admin_default')

@section('title', '試合一覧')

@section('content')
    <h1>試合一覧</h1>
    {{ $matches->links() }}
    <table class="table table-bordered">
        @foreach($matches as $match)
            <tr class="row m-0 {{ $match->bg_color() }}">
                <td class="col-1 bg-theme">{{ $match->id }}</td>
                <td class="col-7">{{ $match->tournament_name() . $match->tournament_sub_name() }}</td>
                <td class="col-4">{{ $match->start_at->isoFormat('Y年M月D日(ddd) HH:mm') }}開始</td>
            </tr>
            <tr class="row m-0 {{ $match->bg_color() }}">
                <td class="col-3">①{{ $match->team1->name }}</td>
                <td class="col-1">{{ $match->team1_votes }}票</td>
                <td class="col-3">②{{ $match->team2->name }}</td>
                <td class="col-1">{{ $match->team2_votes }}票</td>
                <td class="col-2">ホームアウェイ: 
                    @if($match->homeaway === config('const.STATUS.ON')) 
                        ◯
                    @else
                        ×
                    @endif
                </td>
                <td class="col-2">注目の投票: 
                    @if($match->focus_status === config('const.STATUS.ON')) 
                        ◯
                    @else
                        ×
                    @endif
                </td>
            </tr>
            <tr class="row m-0 text-center {{ $match->bg_color() }}">
                <td class="col-1">
                    @if($match->open_status() === config('const.OPEN_STATUS.RESERVED')) 
                        公開前
                    @elseif($match->open_status() === config('const.OPEN_STATUS.OPEN')) 
                        受付中
                    @else
                        終了
                    @endif
                </td>
                <td class="col-5">
                    公開日時: {{ $match->open_at->isoFormat('Y年M月D日(ddd) HH:mm') }}
                </td>
                <td class="col-2 p-1">
                    <a href="{{ action('admin\MatchCommentsController@index', $match) }}" class="btn btn-success">コメント一覧</a>
                </td>
                <td class="col-2 p-1">
                    @if($match->open_status() === config('const.OPEN_STATUS.CLOSED')) 
                        <p>編集不可</p> 
                    @else
                        <a href="{{ action('admin\MatchesController@edit', $match) }}" class="btn btn-primary">編集</a>
                    @endif
                </td>
                <td class="col-2 p-1">
                    <form method="POST" action="{{ action('admin\MatchesController@destroy', $match) }}">
                        @csrf
                        @method('DELETE')
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-danger delete">削除</button>
                        </div>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $matches->links() }}

    <script>
        $('.delete').on('click', () => confirm('本当に削除しますか？'));
    </script>
@endsection