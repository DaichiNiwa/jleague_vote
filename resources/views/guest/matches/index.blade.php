@extends('layouts.default')

@section('title', 'すべての試合 / Jリーグ勝者予想')

@section('content')

    <h3>すべての試合</h3>
    {{ $matches->links() }}
    <div class="row">
        @include('guest.layouts.match_card', ['matches' => $matches])
    </div>
    {{ $matches->links() }}

@endsection
