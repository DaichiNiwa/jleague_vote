<?php

namespace App\Services;

use App\Notice;
use App\Match;
use App\MatchComment;
use App\Survey;
use App\SurveyComment;

use Carbon\Carbon;

use App\Mail\Contact;
use App\Mail\Thanks;

class GuestService
{
    // すべてのお知らせを取得
    public function get_all_notices()
    {
        return  Notice::latest()->get();
    }

    // 受付中のすべてのアンケートを取得
    public function get_open_surveys()
    {
        return Survey::where('close_at', '>=' , Carbon::today())
            ->orderBy('close_at')
            ->get();
    }

    // 公開中のすべての試合を取得
    public function get_all_matches()
    {
        return  Match::where([
            ['open_at', '<=' , Carbon::now()]
            ])->orderBy('start_at', 'desc')
            ->paginate(config('const.NUMBERS.SHORT_PAGINATE'));
    }

    // 今日の試合を取得
    public function get_today_matches()
    {
        return  Match::where('open_at', '<=' , Carbon::now())
            ->whereDate('start_at', Carbon::today())
            ->orderBy('start_at')
            ->get();
    }

    // 注目の試合を取得
    public function get_focus_matches()
    {
        return  Match::where([
            ['focus_status', config('const.STATUS.ON')],
            ['start_at', '>=' , Carbon::today()],
            ['open_at', '<=' , Carbon::now()]
            ])->orderBy('start_at')
            ->get();
    }

    // 今週の試合を取得
    public function get_weekly_matches()
    {
        return  Match::where([
            ['start_at', '>=' , Carbon::tomorrow()],
            ['start_at', '<=' , Carbon::today()->addWeek()],
            ['open_at', '<=' , Carbon::now()]
            ])->orderBy('start_at')
            ->get();
    }

    // 管理者に問い合わせメール、ユーザーに確認メールをそれぞれ送信
    public function send_contact_mails($contact)
    {
        // 管理者に問い合わせ内容を送信
        \Mail::to(config('const.ADMIN_MAIL'))->send(new Contact($contact));
        // ユーザーに確認メールを自動返信
        \Mail::to($contact['email'])->send(new Thanks($contact));
    }

    // 「全X件中XーX件目のコメント」のテキストを生成
    public function generate_pagenate_text($item, $comments)
    {
        $total_comments_count = $item->comments_amount();
        if($comments->firstItem() === $comments->lastItem()){
            return "全" . $total_comments_count . "件中 " . $comments->firstItem() . "件目のコメント";
        } else {
            return "全" . $total_comments_count . "件中 " . $comments->firstItem() . " - " . $comments->lastItem() . "件目のコメント";
        }
    }
    
    // 試合コメントを登録
    public function store_match_comment($match_id, $request, $next_comment_number)
    {
        MatchComment::create([
            'match_id' => $match_id,
            'comment_number' => $next_comment_number,
            'name' => $request->nickname,
            'voted_to' => $request->voted_to,
            'comment' => $request->comment,
            ]);
    }

    // アンケートコメントを登録
    public function store_survey_comment($survey_id, $request, $next_comment_number)
    {
        SurveyComment::create([
            'survey_id' => $survey_id,
            'comment_number' => $next_comment_number,
            'name' => $request->nickname,
            'voted_to' => $request->voted_to,
            'comment' => $request->comment,
            ]);
    }
    
    // コメント番号を生成
    public function next_comment_number($last_comment_number)
    {
        if($last_comment_number === 0){
            return 1;
        } else {
            return $last_comment_number + 1;
        }
    }

    // 試合のTwitterカード用の情報を取得
    public function get_twitter_card_match(Match $match)
    {
        $twitter_card['url'] = url('matches/'. $match->id);
        $twitter_card['title'] = $match->team1->name . " VS " . $match->team2->name; 
        $twitter_card['description'] = $match->start_at->isoFormat('Y年M月D日(ddd) HH:mm') . "試合開始！どちらが勝つか予想してみよう！";
        return $twitter_card;
    }

    // アンケートのTwitterカード用の情報を取得
    public function get_twitter_card_survey(Survey $survey)
    {
        $twitter_card['url'] = url('surveys/'. $survey->id);
        $twitter_card['title'] = $survey->question; 
        $twitter_card['description'] = "あなたの意見を投票してみよう！";
        return $twitter_card;
    }
}