@foreach($surveys as $survey)
    <div class="card small-card">
        <div class="card-header blue-light">
            <span>{{ $survey->question }}</span>
        </div>
        <div class="card-body {{ $survey->card_body_color() }}">
            <div class="row mx-0">
                @if($survey->is_open() === true)
                    <a href="#" class="btn bg-theme-light btn-bagde col-5 col-md-3">投票<span class="badge badge-light">5555</span></a>
                @else
                    <a href="#" class="btn btn-secondary btn-bagde col-5 col-md-3">結果<span class="badge badge-light">5555</span></a>
                @endif
                <a href="#" class="btn btn-primary btn-bagde col-5 col-md-3 ml-3 ">コメント<span class="badge badge-light">{{ $survey->comments_amount() }}</span></a>
            </div>
            <p class="card-text small text-right mt-2">締切：{{ $survey->close_at->isoFormat('Y年M月D日(ddd)') }}00:00</p>
        </div>
    </div>
@endforeach