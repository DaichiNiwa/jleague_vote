<?php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;

use App\Services\GuestService;

class TopPageController extends Controller
{
    public function __construct(GuestService $guestService)
    {
        $this->guestService = $guestService;
    }

    // 管理者用トップページ表示
    public function top()
    {
        // お知らせ、アンケート、今日の投票、注目の投票、１週間の投票をそれぞれ取得
        $notices = $this->guestService->get_all_notices();
        $surveys = $this->guestService->get_open_surveys();
        $today_matches = $this->guestService->get_today_matches();
        $focus_matches =$this->guestService->get_focus_matches();
        $weekly_matches = $this->guestService->get_weekly_matches();

        return view('guest.top', compact('notices', 'surveys', 'today_matches', 'focus_matches', 'weekly_matches'));
    }

    // お問い合わせ画面表示
    public function contact()
    {
        return view('guest.contact.contact');
    }

    // お問い合わせ送信
    public function send(ContactRequest $request)
    {
        // このサイトをポートフォリオとして公開している場合、実際には返信しない。
        if(config('const.AUTH.IS_PORTFOLIO') === true){
            session()->flash('warning', 'ポートフォリオとして公開しているため、お問い合わせをすることはできません。');
            return redirect('/contact');
        }

        $contact = $request->all();
        //二重送信防止のためトークンを再生成 
        $request->session()->regenerateToken();
        
        // 管理者に問い合わせメール、ユーザーに確認メールをそれぞれ送信
        $this->guestService->send_contact_mails($contact);

        return view('guest.contact.thanks');
    }

    // このサイトについて画面表示
    public function about()
    {
        return view('guest.about');
    }

    // このサイトの紹介画面表示
    public function welcome()
    {
        return view('guest.welcome');
    }

}
