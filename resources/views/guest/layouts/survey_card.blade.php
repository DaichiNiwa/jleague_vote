@foreach($surveys as $survey)
    <div class="card small-card">
        <div class="card-header blue-light">
            <span>{{ $survey->question }}</span>
        </div>
        <div class="card-body {{ $survey->card_body_color() }}">
            <div class="d-flex">
                @if($survey->is_open() === true)
                    <a href="{{ action('guest\SurveysController@show', $survey) }}" class="btn bg-theme-light">投票<span class="badge badge-light">{{ $survey->votes_amount() }}</span></a>
                @else
                    <a href="{{ action('guest\SurveysController@show', $survey) }}" class="btn btn-secondary">結果<span class="badge badge-light">{{ $survey->votes_amount() }}</span></a>
                @endif
                <a href="{{ action('guest\SurveyCommentsController@index', $survey) }}" class="btn btn-primary ml-3">コメント<span class="badge badge-light">{{ $survey->comments_amount() }}</span></a>
            </div>
            <p class="card-text small text-right mt-2">締切：{{ $survey->close_at->isoFormat('Y年M月D日(ddd)') }}00:00</p>
        </div>
    </div>
@endforeach