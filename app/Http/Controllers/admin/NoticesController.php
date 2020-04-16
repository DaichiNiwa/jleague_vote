<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Notice;
use Illuminate\Http\Request;

class NoticesController extends Controller
{
     // ログイン認証
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // お知らせ一覧画面表示
    public function index()
    {
        $notices = Notice::All();
        return view('admin.notices', compact('notices'));
    }

    // お知らせ新規登録
    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => ['required', 'max:250'],
        ]);

        Notice::create([
            'body' => $request['body'],
        ]);
        session()->flash('message', 'お知らせを新規登録しました。');
        return redirect('/admin/notices');
    }

    // お知らせ削除
    public function destroy(Notice $notice)
    {
        $notice->delete();
        session()->flash('message', 'お知らせを削除しました。');
        return redirect('/admin/notices');
    }
}
