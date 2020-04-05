@extends('layouts.admin_default')

@section('title', 'アンケート一覧')

@section('content')
    <h1>アンケート一覧</h1>
    {{ $surveys->links() }}
    <table class="table table-bordered">
        @foreach($surveys as $survey)
            <tr class="row m-0 {{ $survey->bg_color() }}">
                <td class="col-12 ">{{ $survey->question }}</td>
            </tr>
            <tr class="row m-0 text-center {{ $survey->bg_color() }}">
                <td class="col-2">@if($survey->is_open()) 受付中 @else 投票終了 @endif</td>
                <td class="col-4">締切日: {{ $survey->close_at->format('Y年m月d日(D) H:i') }}</td>
                <td class="col-2">
                    <a href="{{ action('admin\SurveyCommentsController@index', $survey) }}" class="btn btn-success">コメント一覧</a>
                </td>
                <td class="col-2">
                    <a href="{{ action('admin\SurveysController@edit', $survey) }}" class="btn btn-primary">編集</a>
                </td>
                <td class="col-2">
                    <form method="POST" action="{{ action('admin\SurveysController@destroy', $survey) }}">
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

    <script>
        $('.delete').on('click', () => confirm('本当に削除しますか？'));
    </script>
@endsection