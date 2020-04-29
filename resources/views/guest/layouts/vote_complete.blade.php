@if(session('message'))
<div class="alert alert-success">
    {{ session('message') }}
    <p class="mt-2 mb-0">@include('guest.layouts.twitter_link.vote_finish', ['match' => $match, 'message' => session('message')])</p>
</div>
@endif
