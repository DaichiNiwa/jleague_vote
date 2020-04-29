<?php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use App\Match;
use App\Services\GuestService;
use App\Http\Requests\MatchCommentRequest;

class MatchCommentsController extends Controller
{
    public function __construct(GuestService $guestService)
    {
        $this->guestService = $guestService;
    }

    // すべての試合コメント表示
    public function index(Match $match)
    {
        $comments = $match->get_comments();

        // 「全X件中XーX件目のコメント」のテキストを生成
        $pagenate_text = $this->guestService->generate_pagenate_text($match, $comments);
        return view('guest.matches.comments', compact('match', 'comments', 'pagenate_text'));
    }

    // 試合コメント投稿画面表示
    public function create(Match $match)
    {
        // コメント総数が上限(1000)に達している場合、これ以上投稿できない
        if($match->are_comments_full() === true){
            return redirect()->action('guest\MatchesController@show', ['match' => $match]);
        }
        return view('guest.matches.create_comment', compact('match'));
    }

    // 試合コメント投稿
    public function store(MatchCommentRequest $request, Match $match)
    {
        // コメント総数が上限(1000)に達している場合、これ以上投稿できない
        if($match->are_comments_full() === true){
            return redirect()->action('guest\MatchesController@show', $match);
        }

        // コメント番号を生成
        $next_comment_number = $this->guestService->next_comment_number($match->last_comment_number());

        // コメントを登録
        $this->guestService->store_match_comment($match->id, $request, $next_comment_number);

        session()->flash('message', 'コメントを投稿しました。');
        return redirect()->action('guest\MatchCommentsController@index', $match);
    }

}
