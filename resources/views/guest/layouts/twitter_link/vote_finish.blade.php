<a href="https://twitter.com/intent/tweet
?text={{ $message }}%0a%0a
【{{ $match->tournament_name() }}
@if($match->tournament_sub_name() !== ''){{ '　' . $match->tournament_sub_name() }}@endif】%0a
{{ $match->team1->name }}%0a
{{ $match->team2->name }}%0a
{{ $match->start_at->isoFormat('Y年M月D日(ddd) H:mm') }}開始%0a%0a
&url=https%3A%2F%2F{{ config('app.url') . '%2Fmatches%2F' . $match->id }}
&hashtags=Jリーグ投票"
class="tweet-btn">
    <i class="fab fa-twitter mr-1"></i><span>投票をTweet</span>
</a>