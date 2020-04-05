@extends('layouts.admin_default')

@section('title', 'お知らせ一覧')

@section('content')
    <h1>お知らせ一覧</h1>
    <table class="table table-striped">
        <tr class="row">
            <th class="col-9">本文</th>
            <th class="col-2">掲載日時</th>
            <th class="col-1">削除</th>
        </tr>
        @foreach($notices as $notice)
            <tr class="row">
                <td class="col-9">{{ $notice->body }}</td>
                <td class="col-2">{{ $notice->created_at }}</td>
                <td class="col-1">
                    <form method="POST" action="{{ action('admin\NoticesController@destroy', $notice) }}">
                        @csrf
                        @method('DELETE')
                        <div class="form-group">
                            <div class="">
                                <button type="submit" class="btn btn-danger delete">削除</button>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    <div class="card">
        <div class="card-header">新規登録</div>

        <div class="card-body">
            <p>本文は250文字以内で記入してください。</p>
            <form method="POST" action="{{ action('admin\NoticesController@store') }}">
                @csrf
                <div class="form-group">
                    <textarea rows="3" class="form-control @error('body') is-invalid @enderror" name="body" required autocomplete="body">{{ old('body') }}</textarea>
                    @error('body')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">
                        新規登録
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $('.delete').on('click', () => confirm('本当に削除しますか？'));
    </script>
@endsection