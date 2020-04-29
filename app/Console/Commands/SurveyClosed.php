<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Survey;
use Carbon\Carbon;
use App\Notifications\TwitterSurveyClosed;
use NotificationChannels\Twitter\TwitterChannel;

class SurveyClosed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SurveyClosed:closed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This laravel cronjob is used to notice a survey has been closed on Twitter';

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
        // ツイッターステータスが受付中で、現在時刻が終了時刻を過ぎているアンケートは
        // もう受付終了したものとして1件取得
        $survey = Survey::where([
            ['twitter_status', config('const.OPEN_STATUS.OPEN')],
            ['close_at', '<=', Carbon::now()]
        ])->first();

        // 上の条件に合うアンケートが存在する場合、ステータスを終了に変更した上で、
        // アンケートの受付終了をTwitterで告知
        if(isset($survey)){
            // ステータスを受付終了に変更
            $survey->twitter_status = config('const.OPEN_STATUS.CLOSED');
            $survey->save();
            // ツイッターに投稿
            \Notification::route(TwitterChannel::class, '')->notify(new TwitterSurveyClosed($survey));
        }
    }
}
