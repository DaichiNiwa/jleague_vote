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

    // 試合一覧表示
    public function index()
    {
        $matches = Match::OrderBy('start_at', 'desc')->paginate(config('const.NUMBERS.LONG_PAGINATE'));
        return view('admin.matches.index', compact('matches'));
    }

    // 試合新規登録表示
    public function create()
    {
        return view('admin.matches.create');
    }

    // 試合記入確認表示
    public function confirm(MatchRequest $request)
    {
        $match = $request->all();
        // 入力された情報をまとめて変換
        $match = $this->matchService->change_match_for_confirm($match);
        // セッションに保存
        session(['match' => $match]);
        return view('admin.matches.confirm', compact('match'));
    }

    // 試合記入修正表示
    public function revise()
    {
        //セッションから取得
        $match = session('match');
        return view('admin.matches.revise', compact('match'));
    }

    // 試合新規登録
    public function store()
    {
        //セッションから取得してから破棄
        $match = session()->pull('match');
        // テーブルに保存
        $this->matchService->insert_match($match);
        return redirect('/admin/matches/create');
    }

    // 試合編集表示
    public function edit(Match $match)
    {
        // 終了した試合は編集できないのでリダイレクト
        if($match->open_status() === config('const.OPEN_STATUS.CLOSED')){
            return redirect('/admin/matches');
        }
        // 予約投稿を設定の日時を取得
        $reserve_date = $match->reserve_date();
        $reserve_time = $match->reserve_time();
        return view('admin.matches.edit.edit', compact('match', 'reserve_date', 'reserve_time'));
    }

    // 試合編集記入確認表示
    public function edit_confirm(MatchRequest $request)
    {
        $match = $request->all();
        // 入力された情報をまとめて変換
        $match = $this->matchService->change_match_for_confirm($match);
        // セッションに保存
        session(['match' => $match]);
        return view('admin.matches.edit.confirm', compact('match'));
    }

    // 試合編集記入修正表示
    public function edit_revise()
    {
        //セッションから取得
        $match = session('match');
        // 試合が今、受付中かどうか取得
        $open_status = Match::find($match['id'])->open_status();
        return view('admin.matches.edit.revise', compact('match', 'open_status'));
    }

    // 試合編集して更新
    public function update()
    {
        //セッションから取得してから破棄
        $match = session()->pull('match');
        // 試合を更新
        $this->matchService->update_match($match);
        return redirect('/admin/matches');
    }

    // 試合削除
    public function destroy(Match $match)
    {
        $match->delete();
        session()->flash('message', '試合を削除しました。');
        return redirect('/admin/matches');
    }
}
