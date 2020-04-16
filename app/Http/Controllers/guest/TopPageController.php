<?php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notice;
use App\Match;
use App\Survey;
use Carbon\Carbon;

class TopPageController extends Controller
{
    // 管理者用トップページ表示
    public function top()
    {
        $notices = Notice::latest()->get();
        $surveys = Survey::where('close_at', '>=' , Carbon::today())
            ->orderBy('close_at')
            ->get();
        $foucsed_matches = Match::where([
            ['focus_status', 1],
            ['start_at', '>=' , Carbon::today()],
            ['reserve_at', '<=' , Carbon::now()]
            ])->orderBy('start_at')
            ->get();
            dd($foucsed_matches);

        $notices = Notice::latest()->get();
        dd($notices);
        return view('guest.top');
    }

    // ログイン履歴表示
    // public function login_records()
    // {
    //     $login_records = LoginRecord::latest()->paginate(config('const.NUMBERS.LONG_PAGINATE'));
    //     return view('admin.users.login_records', compact('login_records'));
    // }

    // //管理者一覧表示
    // public function index()
    // {
        
    //     $users = User::All();
    //     return view('admin.users.index', compact('users'));
    // }
}
