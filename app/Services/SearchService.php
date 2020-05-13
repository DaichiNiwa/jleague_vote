<?php

namespace App\Services;

use App\Match;
use App\Team;

use Carbon\Carbon;

class SearchService
{
    
    // チームに応じて検索結果を取得
    public function get_searched_matches($team1, $team2)
    {
        // 2つとも無効なチームが入力されたとき
        if($team1 === null && $team2 === null) {
            return [];
        }

        // チーム1だけ入力されたとき(チーム２が入力されていないとき)
        if($team2 === null) {
            return $this->get_matches_by_team($team1);
        }
        
        // チーム1が無効で、チーム２だけ有効なチームが入力されたとき
        if($team1 === null) {
            return $this->get_matches_by_team($team2);
        }

        // 同じチームが入力されたとき
        if($team1->id === $team2->id) {
            return $this->get_matches_by_team($team1);
        }
        
        // チームが２つ入力されたとき
        return $this->get_matches_by_two_teams($team1, $team2);
    }

    // 記入されたキーワードからチームを１つ取得
    public function get_team($keyword)
    {
        if($keyword === null){
            return null;
        }
        return Team::where('name', 'LIKE', "%{$keyword}%")->first();
    }

    // 1つのチームから試合を取得
    public function get_matches_by_team($team1)
    {
        return  Match::where([
            ['open_at', '<=' , Carbon::now()],
            ['team1_id', $team1->id]
            ])
            ->orWhere([
                ['open_at', '<=' , Carbon::now()],
                ['team2_id', $team1->id]
            ])
            ->orderBy('start_at', 'desc')
            ->paginate(config('const.NUMBERS.SHORT_PAGINATE'));
    }

    // 2つのチームから試合を取得
    public function get_matches_by_two_teams($team1, $team2)
    {
        return  Match::where([
            ['open_at', '<=' , Carbon::now()],
            ['team1_id', $team1->id],
            ['team2_id', $team2->id],
            ])
            ->orWhere([
                ['open_at', '<=' , Carbon::now()],
                ['team1_id', $team2->id],
                ['team2_id', $team1->id]
            ])
            ->orderBy('start_at', 'desc')
            ->paginate(config('const.NUMBERS.SHORT_PAGINATE'));
    }

    // 「全X件中XーX件目の試合」のテキストを生成
    public function generate_pagenate_text($matches)
    {
        // 試合が1つもない場合
        if(count($matches) <= 0){
            return null;
        }

        if($matches->firstItem() === $matches->lastItem()){
            return "全" . $matches->total() . "件中 " . $matches->firstItem() . "件目の試合";
        } else {
            return "全" . $matches->total() . "件中 " . $matches->firstItem() . " - " . $matches->lastItem() . "件目の試合";
        }
    }

}