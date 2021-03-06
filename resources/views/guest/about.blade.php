@extends('layouts.default')

@section('title','サイトのご利用について')

@section('content')
<h2>サイトのご利用について</h2>
<div class="card">
    <div class="card-body">
        <p>試合の投票はお1人様1日1回、アンケートの投票はお1人様1回までです。試合の投票では試合開始日時に、アンケートでは管理者が指定した日時に投票が締め切られます。また、各試合、アンケートの投票の上限数を{{ config('const.NUMBERS.MAX_VOTES') }}としています。</p>
        <p>本サイトでは同一ユーザーによる多重投票を防ぐため、ブラウザのCookieを使用しております。また、ユーザーの判別のため、通信機器から送信されるIPアドレスなどの情報を収集しております。詳細は以下の利用規約をご覧ください。</p>
        <ul>
            <h3>利用規約</h3>
            <p>本サイトの試合、アンケートに投票やコメント投稿される際には、この下記の注意事項をお読みください。投票やコメント投稿をしていただいた場合には、本利用規約等すべてにご同意いただいたものとさせていただきます。また、本サイトは事前に通知することなく、試合、アンケートの内容、本利用規約等を変更することがございますので、予めご了承ください。</p>
            <h4>注意事項</h4>
            <h5>投票について</h5>
            <li>試合の投票はお1人様1日に1回、アンケートの投票はお1人様1回までです。</li>
            <li>不正投票を判別するため、投票の際に通信機器から送信されるIPアドレス、ユーザーエージェントを収集し、本サイトが利用するデータサーバーやコンピューターに送信・保存されることがあります。</li>
            <li>収集したIPアドレスなどの情報は、本サイトの投票機能の運営のみに使用いたします。</li>
            <li>本サイトはブラウザのCookieの設定を有効にしてお楽しみください。無効になっている場合、本サイトの全部または一部サービスがご利用できなくなる場合があります。</li>
            <li>機械的な大量投票やその他の不正投票、および本サイトが不正とみなす投票があった場合、該当する投票は無効とする場合があります。</li>
            <li>投票の変更や取り消しはできかねますので、あらかじめご了承ください。</li>
            <li>システムの障害やメンテナンス等、本サイトが必要と判断した場合には、事前に何ら通告なく投票を休止等する場合があります。</li>
            <li>試合やアンケートの内容、スケジュールは、予告なく変更または中止となる場合があります。</li>
            <li>本サイトは、本サイトへの投票、または、投票者とその他の第三者との間で生じたいかなる紛争についても、その原因の如何を問わず、いかなる責任も負担しないものとします。また、投票者が本サイトの投票に関して被ったいかなる損害についても、その責めを負わないものとします。</li>
            <h5>コメント投稿について</h5>
            <li>本サイトのコメント欄は誰でも自由に投稿・閲覧できますが、以下の例のような不適切なコメントは管理者の判断によって削除または非表示とさせていただく場合があります。</li>
            <li>不適切な投稿例として、公序良俗に反するもの、本サイトの内容と関係がないもの、スパム、宣伝行為、引用の範囲を超えた無断転載、削除された内容の再投稿、なりすまし、個人情報、他者のプライバシーを侵害するもの、個人や集団に対する差別や誹謗中傷などがあります。</li>
            <li>そのほか、管理者が不適切と判断したものは削除します。</li>
            <li>コメントの内容に関する一切の責任はコメントを投稿した利用者ご自身が負うものとします。本サイトは投稿コメントの内容に関して一切責任を負いません。</li>
            <li>本サイトは、本サイトへのコメント、または、コメント投稿者とその他の第三者との間で生じたいかなる紛争についても、その原因の如何を問わず、いかなる責任も負担しないものとします。また、コメント投稿者が本サイトのコメントに関して被ったいかなる損害についても、その責めを負わないものとします。</li>
    </ul>
        <a href="{{ url('/') }}" class="btn btn-secondary">トップページに戻る</a>
    </div>
</div>
@endsection