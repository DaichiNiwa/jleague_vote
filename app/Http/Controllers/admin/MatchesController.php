<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Match;
use App\Http\Requests\MatchRequest;
use App\Services\MatchService;

class MatchesController extends Controller
{
    // ログイン認証
    public function __construct(MatchService $matchService)
    {
        $this->middleware('auth');
        $this->matchService = $matchService;
    }

    // 投票一覧表示
    public function index()
    {
        $matches = Match::OrderBy('start_at', 'desc')->paginate(config('const.NUMBERS.LONG_PAGINATE'));
        return view('admin.matches.index', compact('matches'));
    }

    // 投票新規登録表示
    public function create()
    {
        return view('admin.matches.create');
    }

    // 投票記入確認表示
    public function confirm(MatchRequest $request)
    {
        $match = $request->all();

        // 入力された情報をまとめて変換
        $match = $this->matchService->change_match_for_confirm($match);
        // セッションに保存
        session(['match' => $match]);

        return view('admin.matches.confirm', compact('match'));
    }

    // 投票記入修正表示
    public function revise()
    {
        //セッションから取得
        $match = session('match');
        return view('admin.matches.revise', compact('match'));
    }

    // 投票新規登録
    public function store()
    {
        //セッションから取得してから破棄
        $match = session()->pull('match');
        // テーブルに保存
        $this->matchService->insert_match($match);
        return redirect('/admin/matches/create');
    }

    // 投票編集表示
    public function edit(Match $match)
    {
        // 終了した投票は編集できないのでリダイレクト
        if($match->open_status() === config('const.OPEN_STATUS.CLOSED')){
            return redirect('/admin/matches');
        }
        // 予約投稿を設定の日時を取得
        $reserve_date = $match->reserve_date();
        $reserve_time = $match->reserve_time();
        return view('admin.matches.edit.edit', compact('match', 'reserve_date', 'reserve_time'));
    }

    // 投票編集記入確認表示
    public function edit_confirm(MatchRequest $request)
    {
        $match = $request->all();
        
        // 入力された情報をまとめて変換
        $match = $this->matchService->change_match_for_confirm($match);
        // セッションに保存
        session(['match' => $match]);
        
        return view('admin.matches.edit.confirm', compact('match'));
    }

    // 投票編集記入修正表示
    public function edit_revise()
    {
        //セッションから取得
        $match = session('match');
        // 投票が今、受付中かどうか取得
        $open_status = Match::find($match['id'])->open_status();
        return view('admin.matches.edit.revise', compact('match', 'open_status'));
    }

    // 投票編集して更新
    public function update()
    {
        //セッションから取得してから破棄
        $match = session()->pull('match');
        // 試合を更新
        $this->matchService->update_match($match);

        return redirect('/admin/matches');
    }

    // 投票削除
    public function destroy(Match $match)
    {
        $match->delete();
        session()->flash('message', '投票を削除しました。');
        return redirect('/admin/matches');
    }
}
