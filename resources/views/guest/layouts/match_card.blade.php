@foreach($matches as $match)
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card small-card">
            <div class="card-header orange-light border-bottom-0">
                <p class="card-text">{{ $match->start_at->isoFormat('Y年M月D日(ddd) H:mm') }}開始</p>
                <h5>{{ $match->tournament_name() . '　' . $match->tournament_sub_name() }}</h5>
            </div>

            <div class="progress progress-line">
                <div class="progress-bar bg-choice2" role="progressbar" style="width: {{ $match->team1_percentage() }}%" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-choice3" role="progressbar" style="width: {{ $match->team2_percentage() }}%" aria-valuemin="0" aria-valuemax="100"></div>
            </div>

            <div class="card-body {{ $match->card_body_color() }}">
                <p class="choice1">
                    {{ $match->team1->name }}
                    @if($match->is_homeaway_on() === true)<span class="badge badge-home">Home</span>@endif
                </p>
                <p class="choice4">{{ $match->team2->name }}</p>
                <div class="d-flex">
                    @if($match->is_open() === true)
                        <a href="{{ action('guest\MatchesController@show', $match) }}" class="btn bg-theme-light">投票<span class="badge badge-light">{{ $match->votes_amount() }}</span></a>
                    @else
                        <a href="{{ action('guest\MatchesController@show', $match) }}" class="btn btn-secondary">結果<span class="badge badge-light">{{ $match->votes_amount() }}</span></a>
                    @endif
                    <a href="{{ action('guest\MatchCommentsController@index', $match) }}" class="btn btn-primary ml-3">コメント<span class="badge badge-light">{{ $match->comments_amount() }}</span></a>
                </div>
            </div>
        </div>
    </div>
@endforeach