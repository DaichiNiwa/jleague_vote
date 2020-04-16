<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Survey;
use App\Http\Requests\SurveyRequest;
use Carbon\Carbon;
use App\Notifications\TwitterSurveyStarted;
use NotificationChannels\Twitter\TwitterChannel;

class SurveysController extends Controller
{
    // ログイン認証
    public function __construct()
    {
        // $this->middleware('auth');
    }

    // アンケート一覧表示
    public function index()
    {
        $surveys = Survey::latest()->paginate(config('const.NUMBERS.LONG_PAGINATE'));
        return view('admin.surveys.index', compact('surveys'));
    }

    // アンケート新規登録表示
    public function create()
    {
        // 投票終了日時を発行(明日から１週間後の日付)
        $close_at = Carbon::tomorrow()->addWeek()->toDateString();
        return view('admin.surveys.create', compact('close_at'));
    }

    // アンケート新規登録
    public function store(SurveyRequest $request)
    {
        // 投票終了時刻（$request->close_at）は日付だけで時間を指定していないので、
        // ここで00時00分と指定。
        $close_at = $request->close_at . ' 00:00:00';
        $survey = Survey::create([
            'question' => $request['question'],
            'choice1' => $request['choice1'],
            'choice2' => $request['choice2'],
            'choice3' => $request['choice3'],
            'choice4' => $request['choice4'],
            'choice5' => $request['choice5'],
            'close_at' => $close_at,
        ]);

        // ツイッターに投稿
        \Notification::route(TwitterChannel::class, '')->notify(new TwitterSurveyStarted($survey));
        session()->flash('message', 'アンケートを新規登録しました。');
        return redirect('/admin/surveys');
    }

    // アンケート編集画面表示
    public function edit(Survey $survey)
    {
        return view('admin.surveys.edit', compact('survey'));
    }

    // アンケート編集して更新
    public function update(SurveyRequest $request, Survey $survey)
    {
        // 投票終了時刻（$request->close_at）は日付だけで時間を指定していないので、
        // ここで00時00分と指定。
        $close_at = $request->close_at . ' 00:00:00';

        $survey->question = $request->question;
        $survey->choice1 = $request->choice1;
        $survey->choice2 = $request->choice2;
        $survey->choice3 = $request->choice3;
        $survey->choice4 = $request->choice4;
        $survey->choice5 = $request->choice5;
        $survey->close_at = $close_at;
        $survey->save();
        
        session()->flash('message', 'アンケートの編集が完了しました。');
        return redirect('/admin/surveys');
    }

    // アンケート削除
    public function destroy(Survey $survey)
    {
        $survey->delete();
        session()->flash('message', 'アンケートを削除しました。');
        return redirect('/admin/surveys');
    }
}
