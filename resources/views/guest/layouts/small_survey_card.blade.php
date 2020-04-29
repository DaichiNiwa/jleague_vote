<div class="card small-card mb-3">
    <div class="card-header blue-light border-bottom-0">
        <p class="card-text">締切：{{ $survey->close_at->isoFormat('Y年M月D日(ddd) H:mm') }}</p>
        <h5>{{ $survey->question }}</h5>
    </div>

    <div class="progress progress-line">
        <div class="progress-bar bg-choice1" role="progressbar" style="width: {{ $survey->choice1_percentage() }}%" aria-valuemin="0" aria-valuemax="100"></div>
        <div class="progress-bar bg-choice2" role="progressbar" style="width: {{ $survey->choice2_percentage() }}%" aria-valuemin="0" aria-valuemax="100"></div>
        <div class="progress-bar bg-choice3" role="progressbar" style="width: {{ $survey->choice3_percentage() }}%" aria-valuemin="0" aria-valuemax="100"></div>
        <div class="progress-bar bg-choice4" role="progressbar" style="width: {{ $survey->choice4_percentage() }}%" aria-valuemin="0" aria-valuemax="100"></div>
        <div class="progress-bar bg-choice5" role="progressbar" style="width: {{ $survey->choice5_percentage() }}%" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    <div class="card-body {{ $survey->card_body_color() }}">
        <div class="row justify-content-between mt-4">
            <div class="col-12 col-md-6">
                <div class="row justify-content-between px-2">
                    <p class="choice1 col-8">{{ $survey->choice1 }}</p>
                    <p class="col-4 py-1 px-0"><strong>{{ $survey->choice1_percentage() }} %</strong>（{{ $survey->choice1_amount() }}票）</p>
                </div>
                <div class="row justify-content-between px-2">
                    <p class="choice2 col-8">{{ $survey->choice2 }}</p>
                    <p class="col-4 py-1 px-0"><strong>{{ $survey->choice2_percentage() }} %</strong>（{{ $survey->choice2_amount() }}票）</p>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="row justify-content-between px-2">
                    <p class="choice3 col-8">{{ $survey->choice3 }}</p>
                    <p class="col-4 py-1 px-0"><strong>{{ $survey->choice3_percentage() }} %</strong>（{{ $survey->choice3_amount() }}票）</p>
                </div>
                <div class="row justify-content-between px-2">
                    <p class="choice4 col-8">{{ $survey->choice4 }}</p>
                    <p class="col-4 py-1 px-0"><strong>{{ $survey->choice4_percentage() }} %</strong>（{{ $survey->choice4_amount() }}票）</p>
                </div>
                <div class="row justify-content-between px-2">
                    <p class="choice5 col-8">{{ $survey->choice5 }}</p>
                    <p class="col-4 py-1 px-0"><strong>{{ $survey->choice5_percentage() }} %</strong>（{{ $survey->choice5_amount() }}票）</p>
                </div>
            </div>
        </div>
    </div>
</div>