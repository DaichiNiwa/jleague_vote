<?php

namespace App\Notifications;

use App\Survey;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twitter\TwitterChannel;
use NotificationChannels\Twitter\TwitterStatusUpdate;

class TwitterSurveyStarted extends Notification
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
        $text = "アンケート投票開始！\n【". $this->survey->question ."】\n#Jリーグ投票\n\n投票はこちら\n".
                url('surveys/'. $this->survey->id);
        return (new TwitterStatusUpdate($text));
    }
}
