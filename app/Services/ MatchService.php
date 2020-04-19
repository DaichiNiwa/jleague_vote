<?php

namespace App\Services;

use Carbon\Carbon;
use App\Team;
use App\Match;
use App\Notifications\TwitterVoteStarted;
use NotificationChannels\Twitter\TwitterChannel;

class MatchService
{

    // 0か1で設定されたステータスをbooleanに変換。
    public function is_status_on($status)
    {
        $is_status_on = false;
        if((int)$status === config('const.STATUS.ON')){
            $is_status_on = true;
        }
        return $is_status_on;
    }

    // 記入されたキーワードからチームを１つ取得
    public function get_team($keyword)
    {
        return Team::where('name', 'LIKE', "%{$keyword}%")->first();
    }
    
    // ２つのチームがそれぞれ有効なものかどうかチェック
    public function is_valid_teams($team1, $team2)
    {
        $is_valid = false;
        // team1, team2がそれぞれ取得できていて、同じチームではなければtrue
        if(isset($team1) && isset($team2) && $team1->id !== $team2->id){
            $is_valid = true;
        }
        return $is_valid;
    }

    // 大会名の数字を名前に変換
    public function get_tournament_name($tournament)
    {
        return config('const.TOURNAMENT.'. $tournament);
    }

    // 大会名サブカテゴリの数字を名前に変換
    public function get_tournament_sub_name($tournament, $tournament_sub)
    {
        // 大会がJ1リーグの時は、サブカテゴリを第X節と指定
        if((int)$tournament === config('const.TOURNAMENT_NUMBER.J1')){
            return '第' . $tournament_sub . '節';
        }
        // 大会が天皇杯とルヴァンカップのときは、サブカテゴリを定数から指定
        return config('const.TOURNAMENT_SUB.'. $tournament . '.' . $tournament_sub);
    }

    // 日と時間の文字列から日時のCarbonインスタンスを作成
    public function generate_datetime($match_date, $match_time)
    {
        return new Carbon($match_date . $match_time);
    }
    
    // 予約投稿が設定されていれば、その日時を作成。いなければnullを返す。
    public function generate_reserve_datetime($reserve, $reserve_date, $reserve_time)
    {
        $open_at = null;
        if ($this->is_status_on($reserve) === true) {
            $open_at = new Carbon($reserve_date . $reserve_time);
        }
        return $open_at;
    }

    // 入力された情報をそれぞれ適切に変換
    public function change_match_for_confirm($match){
        // 大会名の数字を名前に変換
        $match['tournament_name'] = $this->get_tournament_name($match['tournament']);

        // 大会のサブカテゴリが入力されていれば、その数字を名前に変換。なければ$match['tournament_sub']にnullを代入
        if(isset($match['tournament_sub'])){
            $match['tournament_sub_name'] = $this->get_tournament_sub_name($match['tournament'], $match['tournament_sub']);
        } else {
            $match['tournament_sub'] = null;
        }
        
        // 記入されたキーワードからそれぞれチームを１つ取得
        $match['team1'] = $this->get_team($match['team1_keyword']);
        $match['team2'] = $this->get_team($match['team2_keyword']);
        // ２つのチームがそれぞれ有効なものかどうかチェック
        $match['is_valid_teams'] = $this->is_valid_teams($match['team1'], $match['team2']);
        
        // 試合開始日時を作成
        $match['start_at'] = $this->generate_datetime($match['match_date'], $match['match_time']);
        // 予約投稿日時日時を作成(予約投稿しない場合はnull)
        $match['open_at'] = $this->generate_reserve_datetime($match['reserve'], $match['reserve_date'], $match['reserve_time']);

        // ホームアウェイ設定と注目の投票設定がそれぞれ1(ON)ならtrue、0(OFF)ならfalseを代入
        $match['is_homeaway_on'] = $this->is_status_on($match['homeaway']);
        $match['is_focus_on'] = $this->is_status_on($match['focus']);

        return $match;
    }

    // 試合を新規登録
    public function insert_match($match)
    {
        // 予約投稿しない場合、ここでopen_atを現在時刻にすることで、即時公開する。
        if($match['open_at'] === null){
            $match['open_at'] = Carbon::now();
        }

        $new_match = Match::create([
            'team1_id' => $match['team1']->id,
            'team2_id' => $match['team2']->id,
            'tournament' => $match['tournament'],
            'tournament_sub' => $match['tournament_sub'],
            'homeaway' => $match['homeaway'],
            'start_at' => $match['start_at'],
            'open_at' => $match['open_at'],
            'focus_status' => $match['focus'],
        ]);

        // 予約投稿が設定されている場合
        if($this->is_status_on($match['reserve']) === true){
            // Twitterで時間がきたら自動で投票開始を告知するようにステータスを設定。
            $new_match->twitter_status = config('const.OPEN_STATUS.RESERVED');
            session()->flash('message', '投票の予約投稿を設定しました。');
        } else {
            // 予約投稿しない場合、即時にTwitterに投稿する。
            \Notification::route(TwitterChannel::class, '')->notify(new TwitterVoteStarted($new_match));
            session()->flash('message', '投票を公開しました。');
        }

        $new_match->save();
    }
    
    // 試合を更新
    public function update_match($match)
    {
        $update_match = Match::find($match['id']);

        $update_match->team1_id = $match['team1']->id;
        $update_match->team2_id = $match['team2']->id;
        $update_match->tournament = $match['tournament'];
        $update_match->tournament_sub = $match['tournament_sub'];
        $update_match->homeaway = $match['homeaway'];
        $update_match->start_at = $match['start_at'];
        $update_match->focus_status = $match['focus'];

        // 予約投稿の場合、予約日時を挿入
        if(isset($match['open_at'])){
            $update_match->open_at = $match['open_at'];
            session()->flash('message', '投票を編集して予約投稿を設定しました。');
        } else {
            // 予約投稿だった投票を即時公開する場合、open_atを現在時刻とする。
            // さらにTwitterステータスを受付中に変更して、投票開始を告知。
            if($update_match->open_status() === config('const.OPEN_STATUS.RESERVED')) {
                $update_match->open_at = Carbon::now();
                $update_match->twitter_status = config('const.OPEN_STATUS.OPEN');
                \Notification::route(TwitterChannel::class, '')->notify(new TwitterVoteStarted($update_match));
            }
            session()->flash('message', '投票を編集して公開しました。');
        }

        $update_match->save();
    }
}