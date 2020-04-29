<?php

namespace App\Notifications;

use App\Survey;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twitter\TwitterChannel;
use NotificationChannels\Twitter\TwitterStatusUpdate;

class TwitterSurveyClosed extends Notification
{

    private $survey;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Survey $survey)
    {
        $this->survey = $survey;
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
        $text = "投票終了！\n【". $this->survey->question ."】\n#Jリーグ投票\n\n結果はこちら\n".
                url('surveys/'. $this->survey->id);
        return (new TwitterStatusUpdate($text));
    }

}
