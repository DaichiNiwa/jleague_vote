<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Match;
use Carbon\Carbon;
use App\Notifications\TwitterVoteStarted;
use NotificationChannels\Twitter\TwitterChannel;

class VoteStarted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'VoteStarted:started';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This laravel cronjob is used to notice a vote has started on Twitter';

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
        // ツイッターステータスが公開前で、現在時刻が公開時刻を過ぎている投票は
        // 受付開始したものとして1件取得
        $match = Match::where([
            ['twitter_status', config('const.OPEN_STATUS.RESERVED')],
            ['open_at', '<=', Carbon::now()]
        ])->first();

        // 上の条件に合う投票が存在する場合、ステータスを受付開始に変更した上で、
        // 投票の受付開始をツイッターで告知
        if(isset($match)){
            // ステータスを受付開始に変更
            $match->twitter_status = config('const.OPEN_STATUS.OPEN');
            $match->save();
            // ツイッターに投稿
            \Notification::route(TwitterChannel::class, '')->notify(new TwitterVoteStarted($match));
        }
    }
}

