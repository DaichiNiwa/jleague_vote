<?php

namespace App\Services;

use App\Survey;
use App\SurveyVote;
use Carbon\Carbon;

class SurveyService
{
    public function __construct()
    {
        $this->today = Carbon::today()->toDateString();
    }

    // 公開中のすべてのアンケートを取得
    public function get_all_surveys()
    {
        return Survey::Orderby('close_at', 'desc')->paginate(config('const.NUMBERS.SHORT_PAGINATE'));
    }

    // 得票数を１つ増やして、投票を挿入、メッセージ挿入
    public function create_survey_vote(Survey $survey, $request)
    {
        // 新しい投票を挿入
        $this->store_survey_vote($survey, $request);
        // cookieに投票の記録
        $this->set_cookie_vote($survey);
        // 投票完了メーセージを作成
        $this->set_message($survey, $request);
    }

    // 新しい投票を挿入
    public function store_survey_vote(Survey $survey, $request)
    {
        SurveyVote::create([
            'survey_id' => $survey->id,
            'voted_to' => $request->voted_to,
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            ]);
    }

    // cookieに投票の記録
    public function set_cookie_vote(Survey $survey)
    {
        $cookie_key = $this->generate_cookie_key($survey);
        // Cookieにこの試合に今日投票したことを記録
        \Cookie::queue($cookie_key, $this->today, config('const.COOKIE_TIME.ONE_MONTH'));
    }

    // 投票完了メーセージを作成
    public function set_message(Survey $survey, $request)
    {
        // 投票した選択肢の文を取得
        $voted_choice = $this->voted_choice($survey, $request);
        session()->flash('message', '「' . $voted_choice  . '」に投票しました！');
    }

    // 投票した選択肢の文を取得
    public function voted_choice(Survey $survey, $request)
    {
        $voted_choice = 'choice' . $request->voted_to;
        return $survey->$voted_choice;
    }

    // 投票を受け付けているかどうかのチェック
    public function is_open(Survey $survey)
    {
        // 投票期間が終了している場合、投票できない
        if($survey->is_open() === false){
            return false;
        }
        // 投票数の合計が上限（２万）に達している場合、これ以上投票できない
        if($survey->are_votes_full() === true){
            return false;
        }
        return true;
    }

    // ユーザーがすでに投票したかどうかのチェック
    public function has_voted(Survey $survey, $request)
    {
        // Cookieに投票した記録が残っている場合、これ以上投票できない
        if($this->has_voted_cookie($survey) === true){
            return true;
        }

        // IPアドレス、UserAgentが全く同じ投票の記録がDBに残っている場合、投票できない
        if($this->has_voted_record($survey, $request) === true){
            return true;
        }
        return false;
    }

    // Cookieに投票した記録が残っているかどうかのチェック
    public function has_voted_cookie(Survey $survey)
    {
        $has_voted = false;
        $cookie_key = $this->generate_cookie_key($survey);
        $cookie = \Cookie::get($cookie_key);

        // Cookieに投票した記録が残っている場合
        if(isset($cookie)){
            $has_voted = true;
        }
        return $has_voted;
    }

    // cookie保存用のキーを生成
    public function generate_cookie_key(Survey $survey)
    {
        return "survey" . $survey->id;
    }

    // IPアドレス、UserAgentが全く同じ投票の記録がDBに残っている場合、投票できない
    public function has_voted_record(Survey $survey, $request)
    {
        $has_voted = false;
        $vote_record = $this->get_vote_record($survey, $request);

        // DBに投票した記録が残っている場合
        if($vote_record !== null){
            $has_voted = true;
        }
        return $has_voted;
    }

    // IPアドレス、UserAgentが全く同じ投票の記録がDBにあれば取得
    public function get_vote_record(Survey $survey, $request)
    {
        return SurveyVote::where([
            ['survey_id', $survey->id],
            ['ip', $request->ip()],
            ['user_agent', $request->header('User-Agent')]
            ])
            ->first();
    }
}