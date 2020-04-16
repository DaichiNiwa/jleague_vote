<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\LoginRecord;
use App\User;
use Gate;

class UsersController extends Controller
{
    // ログイン認証
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 管理者用トップページ表示
    public function top()
    {
        return view('admin.top');
    }

    // ログイン履歴表示
    public function login_records()
    {
        $login_records = LoginRecord::latest()->paginate(config('const.NUMBERS.LONG_PAGINATE'));
        return view('admin.users.login_records', compact('login_records'));
    }

    //管理者一覧表示
    public function index()
    {
        // 主管理者のみアクションを許可
        Gate::authorize('is-master-admin');
        $users = User::All();
        return view('admin.users.index', compact('users'));
    }

    // 管理者の新規登録
    public function store(UserRequest $request)
    {
        // 主管理者のみアクションを許可
        Gate::authorize('is-master-admin');
        User::create([
            'name' => $request['name'],
            'password' => Hash::make($request['password']),
        ]);
        session()->flash('message', '管理者を新規登録しました。');
        return redirect('/admin/users');
    }

    // パスワード変更画面表示
    public function edit(User $user)
    {
        // このサイトをポートフォリオとして公開している場合、主管理者の情報は変更できないようにする。
        if($user->is_admin_and_portfolio()){
            return redirect('/admin/users');
        }
        // 主管理者のみアクションを許可
        Gate::authorize('is-master-admin');
        return view('admin.users.password_change', compact('user'));
        
    }

    // パスワード更新
    public function update(UserRequest $request, User $user)
    {
        // このサイトをポートフォリオとして公開している場合、主管理者の情報は変更できないようにする。
        if($user->is_admin_and_portfolio()){
            return redirect('/admin/users');
        }
        // 主管理者のみアクションを許可
        Gate::authorize('is-master-admin');
        $user->password = Hash::make($request->password);
        $user->save();
        session()->flash('message', 'パスワードを変更しました。');
        return redirect('/admin/users');
    }

    // 管理者削除
    public function destroy(User $user)
    {
        // このサイトをポートフォリオとして公開している場合、主管理者の情報は変更できないようにする。
        if($user->is_admin_and_portfolio()){
            return redirect('/admin/users');
        }
        // 主管理者のみアクションを許可
        Gate::authorize('is-master-admin');
        $user->delete();
        session()->flash('message', '管理者を削除しました。');
        return redirect('/admin/users');
    }
}
