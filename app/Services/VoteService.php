<?php

namespace App\Services;

use App\MatchVote;
use App\Match;

use Carbon\Carbon;

class VoteService
{
    public function __construct()
    {
        $this->today = Carbon::today()->toDateString();
    }

    // 得票数を１つ増やして、投票を挿入、メッセージ挿入
    public function create_match_vote(Match $match, $request)
    {
        // 得票数を１つ増やす
        $this->add_votes($match, $request);
        // 新しい投票を挿入
        $this->store_match_vote($match, $request);
        // cookieに投票の記録
        $this->set_cookie_vote($match);
        // 投票完了メーセージを作成
        $this->set_message($match, $request);
    }

    // 得票数を１つ増やす
    public function add_votes(Match $match, $request)
    {
        // 試合を取得してから、得票数に１をプラスする
        $match = Match::find($match->id);

        // team1に投票した場合
        if((int)$request->voted_to === config('const.TEAM_ID.TEAM1')){
            $match->team1_votes ++;
        // team2に投票した場合
        } elseif ((int)$request->voted_to === config('const.TEAM_ID.TEAM2')){
            $match->team2_votes ++;
        }

        $match->save();
    }

    // 新しい投票を挿入
    public function store_match_vote(Match $match, $request)
    {
        MatchVote::create([
            'match_id' => $match->id,
            'voted_to' => $request->voted_to,
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            ]);
    }

    // cookieに投票の記録
    public function set_cookie_vote(Match $match)
    {
        $cookie_key = $this->generate_cookie_key($match);
        // Cookieにこの試合に今日投票したことを記録
        \Cookie::queue($cookie_key, $this->today, config('const.COOKIE_TIME.ONE_DAY'));
    }

    // 投票完了メーセージを作成
    public function set_message(Match $match, $request)
    {
        // team1に投票した場合
        if((int)$request->voted_to === config('const.TEAM_ID.TEAM1')){
            session()->flash('message', $match->team1->name . 'に投票しました！');
        // team2に投票した場合
        } elseif ((int)$request->voted_to === config('const.TEAM_ID.TEAM2')){
            session()->flash('message', $match->team2->name . 'に投票しました！');
        }
    }

    // 投票を受け付けているかどうかのチェック
    public function is_open(Match $match)
    {
        // 投票期間が終了している場合、投票できない
        if($match->is_open() === false){
            return false;
        }
        // 投票数の合計が上限（２万）に達している場合、これ以上投票できない
        if($match->are_votes_full() === true){
            return false;
        }
        return true;
    }

    // ユーザーがすでに投票したかどうかのチェック
    public function has_voted(Match $match, $request)
    {
        // Cookieに今日、投票した記録が残っている場合、これ以上投票できない
        if($this->has_voted_cookie($match) === true){
            return true;
        }

        // 投票日、IPアドレス、UserAgentが全く同じ投票の記録がDBに残っている場合、投票できない
        if($this->has_voted_record($match, $request) === true){
            return true;
        }
        return false;
    }

    // Cookieに今日、投票した記録が残っているかどうかのチェック
    public function has_voted_cookie(Match $match)
    {
        $has_voted = false;

        $cookie_key = $this->generate_cookie_key($match);
        $cookie = \Cookie::get($cookie_key);

        // Cookieに今日、投票した記録が残っている場合
        if($cookie === $this->today){
            $has_voted = true;
        }
        return $has_voted;
    }

    // cookie保存用のキーを生成
    public function generate_cookie_key(Match $match)
    {
        return "match" . $match->id;
    }

    // 投票日、IPアドレス、UserAgentが全く同じ投票の記録がDBに残っている場合、投票できない
    public function has_voted_record(Match $match, $request)
    {
        $has_voted = false;
        $vote_record = $this->get_vote_record($match, $request);

        // DBに今日、投票した記録が残っている場合
        if($vote_record !== null){
            $has_voted = true;
        }
        return $has_voted;
    }

    // 投票日、IPアドレス、UserAgentが全く同じ投票の記録がDBにあれば取得
    public function get_vote_record(Match $match, $request)
    {
        return MatchVote::where([
            ['match_id', $match->id],
            ['ip', $request->ip()],
            ['user_agent', $request->header('User-Agent')]
            ])
            ->whereDate('created_at', $this->today)
            ->first();
    }
}