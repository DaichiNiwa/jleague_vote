<?php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use App\Survey;

use App\Services\SurveyService;
use App\Services\GuestService;

class SurveysController extends Controller
{
    public function __construct(SurveyService $surveyService, GuestService $guestService)
    {
        $this->surveyService = $surveyService;
        $this->guestService = $guestService;
    }

    // すべての試合表示
    public function index()
    {
        $surveys = $this->surveyService->get_all_surveys();
        return view('guest.surveys.index', compact('surveys'));
    }

    // 試合個別表示
    public function show(Survey $survey)
    {
        //このアンケートが投票を受け付けているか
        $is_open = $this->surveyService->is_open($survey);
        //ユーザーがすでに投票したか
        $has_voted = $this->surveyService->has_voted_cookie($survey);
        // 試合についたコメントのうち、最初の6つを取得
        $comments = $survey->first_six_comments();
        // Twitterカード用の情報を取得
        $twitter_card = $this->guestService->get_twitter_card_survey($survey);
        return view('guest.surveys.show', compact('survey', 'comments', 'is_open', 'has_voted', 'twitter_card'));
    }
}
