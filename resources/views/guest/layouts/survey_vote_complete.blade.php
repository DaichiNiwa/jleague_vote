@if(session('message'))
<div class="alert alert-success">
    {{ session('message') }}
    <p class="mt-2 mb-0">@include('guest.layouts.twitter_link.survey_vote_finish', ['survey' => $survey, 'message' => session('message')])</p>
</div>
@endif
