<?php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\SurveyVoteRequest;

use App\Survey;
use App\Services\SurveyService;

class SurveyVotesController extends Controller
{
    public function __construct(SurveyService $surveyService)
    {
        $this->surveyService = $surveyService;
    }

    public function store(Survey $survey, SurveyVoteRequest $request)
    {

        // このアンケートが投票を受け付けているかチェック
        if($this->surveyService->is_open($survey, $request) === false){
            session()->flash('warning', 'このアンケートには投票できません。');
            return redirect()->back();
        }

        // 本番環境（多重投票を認めない設定）なら、ユーザーがすでに投票したかチェック
        if(config('const.AUTH.MULT_VOTE_PERMIT') === false 
            && $this->surveyService->has_voted($survey, $request) === true){
            session()->flash('warning', 'あなたはこのアンケートにすでに投票しています。（マンションや学校などの共同のネット回線からアクセスしている場合、投票していなくても投票したとみなされることがあります。）');
            return redirect()->back();
        }
        
        // 投票する
        $this->surveyService->create_survey_vote($survey, $request);
        return redirect()->back();
    }

}