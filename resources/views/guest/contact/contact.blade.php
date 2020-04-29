@extends('layouts.default')

@section('title','お問い合わせ')

@section('content')
<h2>お問い合わせ</h2>
    <p>※お問い合わせをいただいても実際には返信をいたしません。</p>
    <div class="card">
        <div class="card-body">
            <form action="{{ url('/send') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="email">メールアドレス（メールアドレスが公開されることはありません。）</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" required>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="subject">お問い合わせの内容</label>
                    <select name="subject" class="form-control" required>
                        <option value="不適切なコメントの報告" @if(old('subject') === "不適切なコメントの報告" ) selected @endif>不適切なコメントの報告</option>
                        <option value="試合について" @if(old('subject') === "試合について" ) selected @endif>試合について</option>
                        <option value="アンケートについて" @if(old('subject') === "アンケートについて" ) selected @endif>アンケートについて</option>
                        <option value="サイトの運営について" @if(old('subject') === "サイトの運営について" ) selected @endif>サイトの運営について</option>
                        <option value="その他" @if(old('subject') === "その他" ) selected @endif>その他</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="message">本文（600文字以内）</label>
                    <textarea name="message" id="message" class="form-control @error('message') is-invalid @enderror" rows="5" required>{{ old('message') }}</textarea>

                    @error('message')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <p>不適切なコメントの報告をしていただく場合、該当の試合またはアンケートと、コメント番号を明記してください。</p>
                <button type="submit" class="btn btn-primary">送信する</button>
            </form>
        </div>
    </div>
@endsection