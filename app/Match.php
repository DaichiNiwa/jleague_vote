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
        'reserve_at',
        'focus_status',
        'twitter_status',
    ];

    // 日時をCarbonインスタンスとして取得する
    protected $dates = [
        'start_at',
        'reserve_at',
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
        if(isset($this->reserve_at)){
            $reserve_date = $this->reserve_at->toDateString();
        }
        return $reserve_date;
    }

    // 予約投稿の時間を取得
    public function reserve_time()
    {
        $reserve_date = '';
        if(isset($this->reserve_at)){
            $reserve_date = $this->reserve_at->format('H:i');
        }
        return $reserve_date;
    }

    // 投票ステータスを0から2の数字で取得
    public function open_status(){
        $now = Carbon::now();
        // 予約投稿をした場合
        if(isset($this->reserve_at)) {
            // 公開前
            if ($this->reserve_at > $now){
                return config('const.OPEN_STATUS.RESERVED');
            }
            // 投票受付中
            if ($now > $this->reserve_at && $this->start_at > $now){
                return config('const.OPEN_STATUS.OPEN');
            }
        }

        // 予約していない場合
        // 投票受付中
        if ($this->start_at > $now){
            return config('const.OPEN_STATUS.OPEN');
        }

        // 上のどれにも当てはまらないときは投票終了
        return config('const.OPEN_STATUS.CLOSED');
    }

    // 投票ステータスによって色を指定。
    public function bg_color(){
        // デフォルトは投票終了
        $bg_color = 'closed';
        // 公開前
        if ($this->open_status() === config('const.OPEN_STATUS.RESERVED')){
            $bg_color = 'reserved';
        }
        // 投票受付中
        if ($this->open_status() === config('const.OPEN_STATUS.OPEN')){
            $bg_color = 'open';
        }
        return $bg_color;
    }
    
    // 投票についたコメントを、ページネーションの長いリストで取得する。（管理者用ページで使用）
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
                        ['open_status', '0'],
                    ])
                    ->orderBy('comment_number')
                    ->paginate(config('const.NUMBERS.LONG_PAGINATE'));
    }
}
