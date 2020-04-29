<?php

namespace App;

use App\SurveyComment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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

    // 投票数が上限(20000)に達しているかどうか
    public function are_votes_full(){
        $are_votes_full = false;

        if($this->votes_amount() >= config('const.NUMBERS.MAX_VOTES')){
            $are_votes_full = true;
        }
        return $are_votes_full;
    }

    // 総投票数を取得
    public function votes_amount(){
        return $this->hasMany('App\SurveyVote')
                    ->Where('survey_id', $this->id)
                    ->count();
    }

    // 選択肢1の投票数を取得
    public function choice1_amount(){
        return $this->hasMany('App\SurveyVote')
                    ->Where([
                        ['survey_id', $this->id],
                        ['voted_to', config('const.SURVEY.CHOICE1')],
                    ])
                    ->count();
    }

    // 選択肢2の投票数を取得
    public function choice2_amount(){
        return $this->hasMany('App\SurveyVote')
                    ->Where([
                        ['survey_id', $this->id],
                        ['voted_to', config('const.SURVEY.CHOICE2')],
                    ])
                    ->count();
    }

    // 選択肢3の投票数を取得
    public function choice3_amount(){
        return $this->hasMany('App\SurveyVote')
                    ->Where([
                        ['survey_id', $this->id],
                        ['voted_to', config('const.SURVEY.CHOICE3')],
                    ])
                    ->count();
    }

    // 選択肢4の投票数を取得
    public function choice4_amount(){
        return $this->hasMany('App\SurveyVote')
                    ->Where([
                        ['survey_id', $this->id],
                        ['voted_to', config('const.SURVEY.CHOICE4')],
                    ])
                    ->count();
    }

    // 選択肢5の投票数を取得
    public function choice5_amount(){
        return $this->hasMany('App\SurveyVote')
                    ->Where([
                        ['survey_id', $this->id],
                        ['voted_to', config('const.SURVEY.CHOICE5')],
                    ])
                    ->count();
    }

    // 選択肢1の得票率を取得
    public function choice1_percentage(){
        $percentage = 0;
        if ($this->choice1_amount() > 0){
            $percentage = round($this->choice1_amount() / $this->votes_amount() * 100);
        }
        return $percentage;
    }

    // 選択肢2の得票率を取得
    public function choice2_percentage(){
        $percentage = 0;
        if ($this->choice2_amount() > 0){
            $percentage = round($this->choice2_amount() / $this->votes_amount() * 100);
        }
        return $percentage;
    }

    // 選択肢3の得票率を取得
    public function choice3_percentage(){
        $percentage = 0;
        if ($this->choice3_amount() > 0){
            $percentage = round($this->choice3_amount() / $this->votes_amount() * 100);
        }
        return $percentage;
    }

    // 選択肢4の得票率を取得
    public function choice4_percentage(){
        $percentage = 0;
        if ($this->choice4_amount() > 0){
            $percentage = round($this->choice4_amount() / $this->votes_amount() * 100);
        }
        return $percentage;
    }

    // 選択肢5の得票率を取得
    public function choice5_percentage(){
        $percentage = 0;
        if ($this->choice5_amount() > 0){
            $percentage = round($this->choice5_amount() / $this->votes_amount() * 100);
        }
        return $percentage;
    }

    // 投票のコメントを10つずつ取得
    public function get_comments(){
        return $this->hasMany('App\SurveyComment')
                    ->Where([
                        ['survey_id', $this->id],
                        ['open_status', config('const.STATUS.ON')]
                    ])
                    ->orderBy('comment_number')
                    ->paginate(config('const.NUMBERS.COMMENT_PAGINATE'));
    }
    
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
                        ['open_status', config('const.STATUS.OFF')],
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

    // アンケートのコメント数が上限(1000)に達しているかどうか
    public function are_comments_full(){
        $are_comments_full = false;

        if($this->comments_amount() >= config('const.NUMBERS.MAX_COMMENTS')){
            $are_comments_full = true;
        }
        return $are_comments_full;
    }

    // アンケートのコメントの最初の6つを取得
    public function first_six_comments(){
        return $this->hasMany('App\SurveyComment')
                    ->Where([
                        ['survey_id', $this->id],
                        ['open_status', config('const.STATUS.ON')]
                    ])
                    ->orderBy('comment_number')
                    ->limit(6)
                    ->get();
    }

    // アンケートの最新のコメント番号を取得
    public function last_comment_number(){
        $last_comment = SurveyComment::where([
                        ['survey_id', $this->id]
                        ])
                        ->orderBy('comment_number', 'desc')
                        ->first();

        if($last_comment === null){
            $last_comment_number = 0;
        } else {
            $last_comment_number = $last_comment->comment_number;
        }
        return $last_comment_number;
    }
}
