<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchComment extends Model
{
    protected $fillable = [
        'match_id', 'comment_number', 'voted_to', 'name', 'comment', 'open_status',
    ];

    // コメントついた試合を取得
    public function match() {
        return $this->belongsTo('App\Match');
    }

    // コメントが表示か非表示か、表示ならtrueを返す。
    public function is_open(){
        $is_open = false;
        if($this->open_status === 1){
            $is_open = true;
        }
        return $is_open;
    }

    // コメントが表示か非表示かによって色を変えるため、CSSのクラスを指定。
    public function bg_color(){
        // open_statusが1の時、通常の表示の色
        if($this->open_status === 1){
            return 'orange-light';
        }
        // それ以外は非表示の色
        return 'gray-light';
    }

    // 投票したチーム名を取得
    public function voted_team_name(){
        // デフォルトで「どちらも応援」
        $name = 'どちらも';
        // チーム１のとき
        if($this->voted_to === config('const.TEAM_ID.TEAM1')){
            $name = $this->match->team1->name . 'を';
        }

        // チーム2のとき
        if($this->voted_to === config('const.TEAM_ID.TEAM2')){
            $name = $this->match->team2->name . 'を';
        }

        return $name;
    }

    // 投票したチームによって背景色を指定
    public function voted_team_color(){
        // デフォルトで「どちらも応援」
        $color = 'bg-choice5';
        // チーム１のとき
        if($this->voted_to === config('const.TEAM_ID.TEAM1')){
            $color = 'bg-choice2';
        }

        // チーム2のとき
        if($this->voted_to === config('const.TEAM_ID.TEAM2')){
            $color = 'bg-choice3';
        }

        return $color;
    }

    // コメント内に含まれるURLをリンクにして出力
    public function replace_url(){
        $comment = htmlspecialchars($this->comment);
        return preg_replace(config('const.REGEX.URL'), config('const.REGEX.REPLACED_URL'), $comment);
    }

}
