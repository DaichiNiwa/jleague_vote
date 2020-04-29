<?php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use App\Survey;
use App\Services\GuestService;
use App\Http\Requests\SurveyCommentRequest;

class SurveyCommentsController extends Controller
{
    public function __construct(GuestService $guestService)
    {
        $this->guestService = $guestService;
    }

    // すべての試合コメント表示
    public function index(Survey $survey)
    {
        $comments = $survey->get_comments();

        // 「全X件中XーX件目のコメント」のテキストを生成
        $pagenate_text = $this->guestService->generate_pagenate_text($survey, $comments);
        return view('guest.surveys.comments', compact('survey', 'comments', 'pagenate_text'));
    }

    // 試合コメント投稿画面表示
    public function create(Survey $survey)
    {
        // コメント総数が上限(1000)に達している場合、これ以上投稿できない
        if($survey->are_comments_full() === true){
            return redirect()->action('guest\SurveysController@show', ['survey' => $survey]);
        }
        return view('guest.surveys.create_comment', compact('survey'));
    }

    // 試合コメント投稿
    public function store(SurveyCommentRequest $request, Survey $survey)
    {
        // コメント総数が上限(1000)に達している場合、これ以上投稿できない
        if($survey->are_comments_full() === true){
            return redirect()->action('guest\SurveysController@show', $survey);
        }

        // コメント番号を生成
        $next_comment_number = $this->guestService->next_comment_number($survey->last_comment_number());

        // コメントを登録
        $this->guestService->store_survey_comment($survey->id, $request, $next_comment_number);

        session()->flash('message', 'コメントを投稿しました。');
        return redirect()->action('guest\SurveyCommentsController@index', $survey);
    }

}
