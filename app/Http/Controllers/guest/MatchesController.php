<?php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use App\Match;
use App\Http\Requests\SearchRequest;

use App\Services\GuestService;
use App\Services\VoteService;
use App\Services\SearchService;

class MatchesController extends Controller
{
    public function __construct(GuestService $guestService, VoteService $voteService, SearchService $searchService)
    {
        $this->guestService = $guestService;
        $this->voteService = $voteService;
        $this->searchService = $searchService;
    }

    // すべての試合表示
    public function index()
    {
        $matches = $this->guestService->get_all_matches();
        return view('guest.matches.index', compact('matches'));
    }

    // 試合個別表示
    public function show(Match $match)
    {
        // 公開前の投票が入力されたときはリダイレクト
        if($match->open_status() === config('const.OPEN_STATUS.RESERVED')){
            return redirect('/');
        }

        //この試合が投票を受け付けているか
        $is_open = $this->voteService->is_open($match);
        //ユーザーがすでに投票したか
        $has_voted = $this->voteService->has_voted_cookie($match);
        // 試合についたコメントのうち、最初の6つを取得
        $comments = $match->first_six_comments();
        // Twitterカード用の情報を取得
        $twitter_card = $this->guestService->get_twitter_card_match($match);

        return view('guest.matches.show', compact('match', 'comments', 'is_open', 'has_voted', 'twitter_card'));
    }

    // 検索表示
    public function search()
    {
        return view('guest.matches.search');
    }

    // 検索表示
    public function results(SearchRequest $request)
    {
        $keyword1 = $request->keyword1;
        $keyword2 = $request->keyword2;

        // 入力されたキーワードからチームを取得
        $team1 = $this->searchService->get_team($keyword1);
        $team2 = $this->searchService->get_team($keyword2);

        // チームに応じて検索結果を取得
        $matches = $this->searchService->get_searched_matches($team1, $team2);
        // 「全X件中XーX件目の試合」のテキストを生成
        $pagenate_text = $this->searchService->generate_pagenate_text($matches);

        return view('guest.matches.search_results', compact('keyword1', 'keyword2', 'team1', 'team2', 'matches', 'pagenate_text'));
    }

}
