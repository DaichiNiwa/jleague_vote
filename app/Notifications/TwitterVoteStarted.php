<?php

namespace App\Notifications;

use App\Match;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twitter\TwitterChannel;
use NotificationChannels\Twitter\TwitterStatusUpdate;

class TwitterVoteStarted extends Notification
{
    private $match;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Match $match)
    {
        $this->match = $match;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TwitterChannel::class];
    }

    public function toTwitter($notifiable)
    {
        $text = $this->generate_text($this->match);
        return (new TwitterStatusUpdate($text));
    }

    // Twitter投稿の本文を生成
    public function generate_text(Match $match)
    {
        $text = "投票開始！\n\n【" . 
                $match->tournament_name();

        // 大会サブカテゴリがあれば追加
        if($match->tournament_sub_name() !== ''){
            $text .= "　" . $match->tournament_sub_name();
        }
        
        $text .=  "】\n" . 
                $match->team1->name . "\n" . 
                $match->team2->name . "\n" . 
                $match->start_at->isoFormat('Y年M月D日(ddd) HH:mm') . "開始\n" . 
                "#Jリーグ投票\n\n投票はこちら\n".
                url('matches/'. $match->id);
        return $text;
    }
}
