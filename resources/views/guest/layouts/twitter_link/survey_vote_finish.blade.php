<a href="https://twitter.com/intent/tweet
?text=アンケートに投票しました！%0a%0a
【{{ $survey->question }}】%0a%0a
&url=https%3A%2F%2F{{ config('const.URL') . '%2Fsurveys%2F' . $survey->id }}
&hashtags=Jリーグ投票"
class="tweet-btn">
    <i class="fab fa-twitter mr-1"></i><span>投票をTweet</span>
</a>