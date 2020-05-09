<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyComment extends Model
{
    protected $fillable = [
        'survey_id', 'comment_number', 'voted_to', 'name', 'comment', 'open_status',
    ];

    // 各数字を取得する際、データ型をINTにして取得
    protected $casts = [
        'comment_number' => 'integer',
        'voted_to' => 'integer',
        'open_status' => 'integer',
    ];

    // コメントが表示か非表示か、表示ならtrueを返す。
    public function survey(){
        return $this->belongsTo('App\Survey');
    }

    // コメントが表示か非表示か、表示ならtrueを返す。
    public function is_open(){
        $is_open = false;
        if($this->open_status === config('const.STATUS.ON')){
            $is_open = true;
        }
        return $is_open;
    }

    // 投票した選択肢の文を取得
    public function voted_choice(){
        $voted_choice = 'choice' . $this->voted_to;
        return $this->survey->$voted_choice;
    }

    // コメントが表示か非表示かによって色を変えるため、CSSのクラスを指定。
    public function bg_color(){
        // open_statusが1の時、通常の表示の色
        if($this->open_status === config('const.STATUS.ON')){
            return 'orange-light';
        }
        // それ以外は非表示の色
        return 'gray-light';
    }

    // 投票した選択肢によって背景色を指定
    public function voted_choice_color(){
        // デフォルトで選択肢5
        $color = 'bg-choice5';
        // 選択肢1のとき
        if($this->voted_to === config('const.SURVEY.CHOICE1')){
            $color = 'bg-choice1';
        }

        // 選択肢2のとき
        if($this->voted_to === config('const.SURVEY.CHOICE2')){
            $color = 'bg-choice2';
        }

        // 選択肢3のとき
        if($this->voted_to === config('const.SURVEY.CHOICE3')){
            $color = 'bg-choice3';
        }

        // 選択肢4のとき
        if($this->voted_to === config('const.SURVEY.CHOICE4')){
            $color = 'bg-choice4';
        }

        return $color;
    }

    // 投票した選択肢が１か４かどうか（該当のとき、コメントカードで文字色を白にする）
    public function is_choice1_or_4(){
        $is_choice1_or_4 = false;
        // 選択肢１か４のとき
        if($this->voted_to === config('const.SURVEY.CHOICE1') || $this->voted_to === config('const.SURVEY.CHOICE4')){
            $is_choice1_or_4 = true;
        }

        return $is_choice1_or_4;
    }

    // コメント内に含まれるURLをリンクにして出力
    public function replace_url(){
        $comment = htmlspecialchars($this->comment);
        return preg_replace(config('const.REGEX.URL'), config('const.REGEX.REPLACED_URL'), $comment);
    }

    
}
