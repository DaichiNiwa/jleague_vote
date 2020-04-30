<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Match extends Model
{

    protected $fillable = [
        'team1_id',
        'team2_id',
        'team1_votes',
        'team2_votes',
        'tournament',
        'tournament_sub',
        'homeaway',
        'start_at',
        'open_at',
        'focus_status',
        'twitter_status',
    ];

    // 日時をCarbonインスタンスとして取得する
    protected $dates = [
        'start_at',
        'open_at',
    ];

    // 各数字を取得する際、データ型をINTにして取得
    protected $casts = [
        'tournament' => 'integer',
        'tournament_sub' => 'integer',
        'homeaway' => 'integer',
        'focus_status' => 'integer',
    ];

    // 大会名の数字を名前に変換
    public function tournament_name()
    {
        return config('const.TOURNAMENT.'. $this->tournament);
    }

    // 大会名サブカテゴリの数字を名前に変換
    public function tournament_sub_name()
    {
        // サブカテゴリがないときは空文字を返す。
        if($this->tournament_sub === null){
            return '';
        }
        // 大会がJ1リーグの時は、サブカテゴリを第X節と指定
        if($this->tournament === config('const.TOURNAMENT_NUMBER.J1')){
            return '第' . $this->tournament_sub . '節';
        }
        // 大会が天皇杯とルヴァンカップのときは、サブカテゴリを定数から指定
        return config('const.TOURNAMENT_SUB.'. $this->tournament . '.' . $this->tournament_sub);
    }

    // チーム１を取得
    public function team1()
    {
        return $this->hasOne('App\Team', 'id', 'team1_id');
    }

    // チーム2を取得
    public function team2()
    {
        return $this->hasOne('App\Team', 'id', 'team2_id');
    }

    // 予約投稿の日付を取得
    public function reserve_date()
    {
        $reserve_date = '';
        if($this->open_at > Carbon::now()){
            $reserve_date = $this->open_at->toDateString();
        }
        return $reserve_date;
    }

    // 予約投稿の時間を取得
    public function reserve_time()
    {
        $reserve_date = '';
        if($this->open_at > Carbon::now()){
            $reserve_date = $this->open_at->format('H:i');
        }
        return $reserve_date;
    }

    // 試合の公開ステータスを0から2の数字で取得
    public function open_status(){
        $now = Carbon::now();
        // 公開前の場合
        if ($this->open_at > $now){
            return config('const.OPEN_STATUS.RESERVED');
        }
        // 投票受付中の場合
        if ($now > $this->open_at && $this->start_at > $now){
            return config('const.OPEN_STATUS.OPEN');
        }

        // 上記に当てはまらないときは投票終了
        return config('const.OPEN_STATUS.CLOSED');
    }

    // 投票が受付中ならtrueを返す
    public function is_open(){
        $is_open = false;
        if ($this->open_status() === config('const.OPEN_STATUS.OPEN')){
            $is_open = true;
        }
        return $is_open;
    }

    // 投票ステータスによって色を指定。
    public function bg_color(){
        // デフォルトは投票終了
        $bg_color = 'gray-light';
        // 公開前
        if ($this->open_status() === config('const.OPEN_STATUS.RESERVED')){
            $bg_color = 'blue-light';
        }
        // 投票受付中
        if ($this->open_status() === config('const.OPEN_STATUS.OPEN')){
            $bg_color = 'orange-light';
        }
        return $bg_color;
    }

    // 試合が投票受付中か終了かによって試合カードの色を変える。
    public function card_body_color(){
        if ($this->open_status() === config('const.OPEN_STATUS.OPEN')){
            return '';
        }
        return 'gray-light';
    }

    // 試合にホームアウェイ設定をしていればtrueを返す
    public function is_homeaway_on(){
        $is_open = false;
        if ($this->homeaway === config('const.STATUS.ON')){
            $is_open = true;
        }
        return $is_open;
    }

    // 総投票数を取得
    public function votes_amount(){
        return $this->team1_votes + $this->team2_votes;
    }

    // チーム１の得票率
    public function team1_percentage(){
        $percentage = 0;
        if ($this->team1_votes > 0){
            $percentage = round($this->team1_votes / $this->votes_amount() * 100);
        }
        return $percentage;
    }

    // チーム2の得票率
    public function team2_percentage(){
        $percentage = 0;
        if ($this->team2_votes > 0){
            $percentage = round($this->team2_votes / $this->votes_amount() * 100);
        }
        return $percentage;
    }

    // 投票数が上限(20000)に達しているかどうか
    public function are_votes_full(){
        $are_votes_full = false;

        if($this->votes_amount() >= config('const.NUMBERS.MAX_VOTES')){
            $are_votes_full = true;
        }
        return $are_votes_full;
    }
    
    // 試合についたコメントを、ページネーションの長いリストで取得する。（管理者用ページで使用）
    public function comments_longlist(){
        return $this->hasMany('App\MatchComment')
                    ->Where('match_id', $this->id)
                    ->orderBy('comment_number')
                    ->paginate(config('const.NUMBERS.LONG_PAGINATE'));
    }

    // 非表示のコメントのみを、長いリストで取得する。（管理者用ページで使用）
    public function closed_comments_longlist(){
        return $this->hasMany('App\MatchComment')
                    ->Where([
                        ['match_id', $this->id],
                        ['open_status', config('const.STATUS.OFF')],
                    ])
                    ->orderBy('comment_number')
                    ->paginate(config('const.NUMBERS.LONG_PAGINATE'));
    }

    // 試合のコメントの最初の6つを取得
    public function first_six_comments(){
        return $this->hasMany('App\MatchComment')
                    ->Where([
                        ['match_id', $this->id],
                        ['open_status', config('const.STATUS.ON')]
                    ])
                    ->orderBy('comment_number')
                    ->limit(6)
                    ->get();
    }

    // 試合のコメントを10つずつ取得
    public function get_comments(){
        return $this->hasMany('App\MatchComment')
                    ->Where([
                        ['match_id', $this->id],
                        ['open_status', config('const.STATUS.ON')]
                    ])
                    ->orderBy('comment_number')
                    ->paginate(config('const.NUMBERS.COMMENT_PAGINATE'));
    }

    // 試合の公開コメント数を取得
    public function comments_amount(){
        return $this->hasMany('App\MatchComment')
                    ->Where([
                        ['match_id', $this->id],
                        ['open_status', config('const.STATUS.ON')]
                    ])->count();
    }

    // 試合の最新のコメント番号を取得
    public function last_comment_number(){
        $last_comment = MatchComment::where([
                        ['match_id', $this->id]
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

    // 試合のコメント数が上限(1000)に達しているかどうか
    public function are_comments_full(){
        $are_comments_full = false;

        if($this->last_comment_number() >= config('const.NUMBERS.MAX_COMMENTS')){
            $are_comments_full = true;
        }
        return $are_comments_full;
    }

}
