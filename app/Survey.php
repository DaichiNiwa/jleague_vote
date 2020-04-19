<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\SurveyComment;


class Survey extends Model
{
    protected $fillable = [
        'question', 'choice1', 'choice2', 'choice3', 'choice4', 'choice5', 'close_at',
    ];

    // close_atをCarbonインスタンスとして変換する
    protected $dates = [
        'close_at',
    ];

    // アンケートが投票受付中ならtrueを返す
    public function is_open(){
        $is_open = false;
        if ($this->close_at > Carbon::now()){
            $is_open = true;
        }
        return $is_open;
    }

    // アンケートが投票受付中か終了かによって色を変える。
    public function bg_color(){
        if ($this->is_open() === true){
            return 'orange-light';
        }
        return 'gray-light';
    }

    // アンケートが投票受付中か終了かによってアンケートカードの色を変える。
    public function card_body_color(){
        if ($this->is_open() === true){
            return '';
        }
        return 'gray-light';
    }

    // // アンケートの投票数を取得
    // public function card_body_color(){
    //     if ($this->is_open() === true){
    //         return '';
    //     }
    //     return 'gray-light';
    // }
    
    // アンケートについたコメントを、ページネーションの長いリストで取得する。（管理者用ページで使用）
    public function comments_longlist(){
        return $this->hasMany('App\SurveyComment')
                    ->Where('survey_id', $this->id)
                    ->orderBy('comment_number')
                    ->paginate(config('const.NUMBERS.LONG_PAGINATE'));
    }

    // 非表示のコメントのみを、長いリストで取得する。（管理者用ページで使用）
    public function closed_comments_longlist(){
        return $this->hasMany('App\SurveyComment')
                    ->Where([
                        ['survey_id', $this->id],
                        ['open_status', '0'],
                    ])
                    ->orderBy('comment_number')
                    ->paginate(config('const.NUMBERS.LONG_PAGINATE'));
    }

    // アンケートのコメント数を取得
    public function comments_amount(){
        return $this->hasMany('App\SurveyComment')
                    ->Where([
                        ['survey_id', $this->id],
                        ['open_status', config('const.STATUS.ON')]
                    ])->count();
    }
    
}
