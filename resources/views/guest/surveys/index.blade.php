@extends('layouts.default')

@section('title', 'すべてのアンケート / Jリーグ勝者予想')

@section('content')

    <h3>すべてのアンケート</h3>
    {{ $surveys->links() }}
        @include('guest.layouts.survey_card', ['surveys' => $surveys])
    {{ $surveys->links() }}

@endsection
