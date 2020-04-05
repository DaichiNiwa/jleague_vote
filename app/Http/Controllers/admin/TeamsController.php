<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Team;
use App\Http\Requests\TeamRequest;

class TeamsController extends Controller
{
     // ログイン認証
    public function __construct()
    {
        $this->middleware('auth');
    }

    // チーム一覧表示
    public function index()
    {
        $teams = Team::orderBy('ranking')->paginate(config('const.NUMBERS.LONG_PAGINATE'));
        return view('admin.teams.index', compact('teams'));
    }

    // チーム新規登録表示
    public function create()
    {
        return view('admin.teams.create');
    }

    // チーム新規登録
    public function store(TeamRequest $request)
    {
        Team::create([
            'name' => $request['name'],
            'ranking' => $request['ranking'],
        ]);
        session()->flash('message', 'チームを新規登録しました。');
        return redirect('/admin/teams/create');
    }

    // チーム編集画面表示
    public function edit(Team $team)
    {
        return view('admin.teams.edit', compact('team'));
    }

    // チーム編集して更新
    public function update(TeamRequest $request, Team $team)
    {
        // 名前を更新するとき
        if(isset($request->name)){
            $team->name = $request->name;
            session()->flash('message', 'チーム名を変更しました。');
        }

        // 昨年順位を更新するとき
        if(isset($request->ranking)){
            $team->ranking = $request->ranking;
            session()->flash('message', '昨年順位を変更しました。');
        }
        $team->save();
        return redirect('/admin/teams');
    }
}