@foreach($comments as $comment)
    <div class="col-12 col-md-4">
        <div class="card small-card mx-0">
            <div class="card-header {{ $comment->voted_team_color() }}">
                <p class="mb-0">{{ $comment->comment_number . '　'}} 
                    @isset($comment->name) {{ $comment->name }} @else NO NAME @endif <small>さん</small>
                </p>
                <p class="card-text small text-right">{{ $comment->voted_team_name() }}応援！</p>
            </div>

            <div class="card-body">
                <p>{!! nl2br($comment->replace_url()) !!}</p>
                <p class="small text-right mb-0">{{ $comment->created_at->isoFormat('Y年M月D日(ddd) H:mm:ss') }}</p>
            </div>
        </div>
    </div>
@endforeach