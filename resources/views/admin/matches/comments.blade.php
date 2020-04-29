@extends('layouts.admin_default')

@section('title', '試合コメント一覧')

@section('content')
    <h1>試合コメント一覧</h1>
    <p>{{ $match->tournament_name() . $match->tournament_sub_name() }}</p>
    <p>{{ $match->start_at->isoFormat('Y年M月D日(ddd) HH:mm') }}開始</p>
    <p>①{{ $match->team1->name }}　②{{ $match->team2->name }}</p>
    <a href="{{ action('admin\MatchCommentsController@closed_comments', $match) }}" class="btn btn-primary mb-1">非公開のコメントのみ表示</a>
    {{ $match->comments_longlist()->links() }}
    <table class="table table-bordered">
        @forelse($match->comments_longlist() as $comment)
            <tr class="row m-0 text-center {{ $comment->bg_color() }}">
                <td class="col-1">{{ $comment->comment_number }}</td>
                <td class="col-1">@if($comment->is_open()) 表示 @else 非表示 @endif</td>
                <td class="col-5">名前: {{ $comment->name }}</td>
                <td class="col-3">{{ $comment->created_at->isoFormat('Y年M月D日(ddd) HH:mm') }}</td>
                <td class="col-2 p-1">
                    <form method="POST" action="{{ action('admin\MatchCommentsController@update', [$match, $comment]) }}">
                        @csrf
                        @method('PATCH')
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-danger">表示を変更</button>
                        </div>
                    </form>
                </td>
            </tr>
            <tr class="row m-0 {{ $comment->bg_color() }}">
                <td class="col-12 ">{{ $comment->comment }}</td>
            </tr>
        @empty
            <p>コメントはありません。</p>
        @endforelse
    </table>
@endsection