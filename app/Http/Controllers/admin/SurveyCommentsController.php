<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\SurveyComment;
use App\Survey;
use Illuminate\Http\Request;

class SurveyCommentsController extends Controller
{
    // ログイン認証
    public function __construct()
    {
        $this->middleware('auth');
    }

    // コメント一覧表示
    public function index(Survey $survey)
    {
        return view('admin.surveys.comments', compact('survey'));
    }

    // 非表示のコメントのみ一覧表示
    public function closed_comments(Survey $survey)
    {
        return view('admin.surveys.closed_comments', compact('survey'));
    }

    // コメントの公開ステータスを変更（不適切なコメントを非表示に変更）
    public function update(Survey $survey, SurveyComment $comment)
    {
        // 現在のステータスが表示なら非表示に
        if($comment->is_open() === true){
            $comment->open_status = 0;
        } else {
            // 現在のステータスがなら非表示表示に
            $comment->open_status = 1;
        }
        $comment->save();
        session()->flash('message', 'アンケートコメントの表示を変更しました。');
        return redirect()->back();
    }

}
