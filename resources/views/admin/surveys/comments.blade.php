@extends('layouts.admin_default')

@section('title', 'アンケートコメント一覧')

@section('content')
    <h1>アンケートコメント一覧</h1>
    <p>質問文: {{ $survey->question }}</p>
    <a href="{{ action('admin\SurveyCommentsController@closed_comments', $survey) }}" class="btn btn-primary mb-1">非公開のコメントのみ表示</a>
    {{ $survey->comments_longlist()->links() }}
    <table class="table table-bordered">
        @forelse($survey->comments_longlist() as $comment)
            <tr class="row m-0 text-center {{ $comment->bg_color() }}">
                <td class="col-1">{{ $comment->comment_number }}</td>
                <td class="col-1">@if($comment->is_open()) 表示 @else 非表示 @endif</td>
                <td class="col-5">名前: {{ $comment->name }}</td>
                <td class="col-3">{{ $comment->created_at->isoFormat('Y年M月D日(ddd) HH:mm') }}</td>
                <td class="col-2 p-1">
                    <form method="POST" action="{{ action('admin\SurveyCommentsController@update', [$survey, $comment]) }}">
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