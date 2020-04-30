<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\MatchComment;
use App\Match;

class MatchCommentsController extends Controller
{
    // ログイン認証
    public function __construct()
    {
        $this->middleware('auth');
    }

    // コメント一覧表示
    public function index(Match $match)
    {
        return view('admin.matches.comments', compact('match'));
    }

    // 非表示のコメントのみ一覧表示
    public function closed_comments(Match $match)
    {
        return view('admin.matches.closed_comments', compact('match'));
    }

    // コメントの公開ステータスを変更（不適切なコメントを非表示に変更）
    public function update(Match $match, MatchComment $comment)
    {
        // 現在のステータスが表示なら非表示に
        if($comment->is_open() === true){
            $comment->open_status = 0;
        } else {
            // 現在のステータスがなら非表示表示に
            $comment->open_status = 1;
        }
        $comment->save();
        session()->flash('message', '試合コメントの表示を変更しました。');
        return redirect()->back();
    }

}
