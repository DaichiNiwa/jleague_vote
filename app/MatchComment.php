<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchComment extends Model
{
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

    protected $fillable = [
        'match_id', 'comment_number', 'voted_to', 'name', 'comment', 'open_status',
    ];
}
