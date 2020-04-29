    <div class="card small-card mb-3">
        <div class="card-header orange-light border-bottom-0">
            <p class="card-text">{{ $match->start_at->isoFormat('Y年M月D日(ddd) H:mm') }}開始</p>
            <h5>{{ $match->tournament_name() . '　' . $match->tournament_sub_name() }}</h5>
        </div>

        <div class="progress progress-line">
            <div class="progress-bar bg-choice2" role="progressbar" style="width: {{ $match->team1_percentage() }}%" aria-valuemin="0" aria-valuemax="100"></div>
            <div class="progress-bar bg-choice3" role="progressbar" style="width: {{ $match->team2_percentage() }}%" aria-valuemin="0" aria-valuemax="100"></div>
        </div>

        <div class="card-body {{ $match->card_body_color() }}">
            <div class="d-md-flex justify-content-between">
                <p class="choice1 mb-md-0">
                    {{ $match->team1->name . "　" }}
                    {{ $match->team1_percentage() }} %
                    @if($match->is_homeaway_on() === true)<span class="badge badge-home">Home</span>@endif
                </p>
                <p class="choice4 mb-0">
                    {{ $match->team2->name . "　" }}
                    {{ $match->team2_percentage() }} %
                </p>
            </div>
        </div>
    </div>