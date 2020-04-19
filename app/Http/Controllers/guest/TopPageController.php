<?php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Notice;
use App\Match;
use App\Survey;

use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;
use App\Mail\Thanks;
use Carbon\Carbon;

class TopPageController extends Controller
{
    // 管理者用トップページ表示
    public function top()
    {
        // お知らせ、アンケート、今日の投票、注目の投票、１週間の投票をそれぞれ取得
        $notices = Notice::latest()->get();
        $surveys = Survey::where('close_at', '>=' , Carbon::today())
            ->orderBy('close_at')
            ->get();

        $today_matches = Match::where(
            'open_at', '<=' , Carbon::now()
            )->whereDate('start_at', Carbon::today())
            ->orderBy('start_at')
            ->get();

        $focus_matches = Match::where([
            ['focus_status', config('const.STATUS.ON')],
            ['start_at', '>=' , Carbon::today()],
            ['open_at', '<=' , Carbon::now()]
            ])->orderBy('start_at')
            ->get();

        $weekly_matches = Match::where([
            ['start_at', '>=' , Carbon::tomorrow()],
            ['start_at', '<=' , Carbon::today()->addWeek()],
            ['open_at', '<=' , Carbon::now()]
            ])->orderBy('start_at')
            ->get();
        return view('guest.top', compact('notices', 'surveys', 'today_matches', 'focus_matches', 'weekly_matches'));
    }

    // お問い合わせ画面表示
    public function contact()
    {
        return view('guest.contact.contact');
    }

    // お問い合わせ送信
    public function send(Request $request)
    {
        // このサイトをポートフォリオとして公開している場合、実際には返信しない。
        if(config('const.AUTH.IS_PORTFOLIO') === true){
            session()->flash('message', 'ポートフォリオとして公開しているため、お問い合わせをすることはできません。');
            return redirect('/contact');
        }

        $this->validate($request, [
            'email' => 'required|email|max:200',
            'subject'  => 'required|max:15',
            'message' => 'required|max:600',
        ]);

        dd($request);

        $contact = $request->all();

        //二重送信防止のためトークンを再生成 
        $request->session()->regenerateToken();
        
        // 管理者に問い合わせ内容を送信
        Mail::to(config('const.ADMIN_MAIL'))->send(new Contact($contact));
        // ユーザーに確認メールを自動返信
        Mail::to($contact['email'])->send(new Thanks($contact));

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
