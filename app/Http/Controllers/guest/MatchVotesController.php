<?php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\MatchVoteRequest;

use App\Match;
use App\Services\VoteService;

class MatchVotesController extends Controller
{
    public function __construct(VoteService $voteService)
    {
        $this->voteService = $voteService;
    }

    public function store(Match $match, MatchVoteRequest $request)
    {
        //この試合が投票を受け付けているかチェック
        if($this->voteService->is_open($match) === false){
            session()->flash('warning', 'この試合には投票できません。');
            return redirect()->back();
        }

        //本番環境（多重投票を認めない設定）なら、ユーザーがすでに投票したかチェック
        if(config('const.AUTH.MULT_VOTE_PERMIT') === false 
            && $this->voteService->has_voted($match, $request) === true){
            session()->flash('warning', 'あなたは今日すでに投票しています。（マンションや学校などの共同のネット回線からアクセスしている場合、投票していなくても投票したとみなされることがあります。）');
            return redirect()->back();
        }
        
        // 投票する
        $this->voteService->create_match_vote($match, $request);
        return redirect()->back();
    }

}