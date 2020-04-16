<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Match;
use Carbon\Carbon;
use App\Notifications\TwitterVoteClosed;
use NotificationChannels\Twitter\TwitterChannel;

class VoteClosed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'VoteClosed:closed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This laravel cronjob is used to notice a vote has been closed on Twitter';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // ツイッターステータスが投票受付中で、現在時刻が締切時刻(試合開始時刻)を
        // 過ぎている投票は受付終了したものとして1件取得
        $match = Match::where([
            ['twitter_status', config('const.OPEN_STATUS.OPEN')],
            ['start_at', '<=', Carbon::now()]
        ])->first();

        // 上の条件に合う投票が存在する場合、ステータスを受付終了に変更した上で、
        // 投票の受付終了をTwitterで告知
        if(isset($match)){
            // ステータスを受付終了に変更
            $match->twitter_status = config('const.OPEN_STATUS.CLOSED');
            $match->save();
            // ツイッターに投稿
            \Notification::route(TwitterChannel::class, '')->notify(new TwitterVoteClosed($match));
        }
    }
}
