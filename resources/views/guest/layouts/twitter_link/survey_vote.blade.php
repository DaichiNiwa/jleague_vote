<a href="https://twitter.com/intent/tweet?
text=@if($survey->is_open() === true)アンケート受付中！@elseアンケート結果！@endif%0a%0a
【{{ $survey->question }}】%0a%0a
&url={{ config('app.url') . '%2Fsurveys%2F' . $survey->id }}
&hashtags=Jリーグ投票"
class="tweet-btn"
>
    <i class="fab fa-twitter mr-1"></i><span>Tweet</span>
</a>