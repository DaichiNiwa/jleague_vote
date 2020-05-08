<?php
return [
    // 管理者のメールアドレス
    'ADMIN_MAIL' => '@yahoo.co.jp',

    'AUTH' => [
        // このサイトをポートフォリオとして公開している場合、true。
        // お問い合わせを停止。主管理者の情報を変更できないようにする。
        'IS_PORTFOLIO' => true,
        // 多重投票を許可するならtrue。本番環境ではfalse
        'MULT_VOTE_PERMIT' => true,
    ],

    'NUMBERS' => [
        // ページネーションでリスト表示をする際、１つのリストでの表示件数。
        'LONG_PAGINATE' => 50,
        'SHORT_PAGINATE' => 30,
        'COMMENT_PAGINATE' => 10,
        // 投票できる上限数
        'MAX_VOTES' => 20000,
        // コメントできる上限数
        'MAX_COMMENTS' => 1000,
    ],

    'ID' => [
        // 主管理者のID
        'MASTER_ADMIN' => 1,
    ],

    'STATUS' => [
        'OFF' => 0,
        'ON' => 1,
    ],

    // クッキーの有効期限
    'COOKIE_TIME' => [
        'ONE_DAY' => 60 * 24,
        'ONE_MONTH' => 60 * 24 * 31,
    ],

    // 応援するチームのID
    'TEAM_ID' => [
        'TEAM1' => 0,
        'TEAM2' => 1,
        'BOTH' => 2,
    ],

    // 投票とアンケートの投票ステータス（公開前、受付中、受付終了）
    'OPEN_STATUS' => [
        'RESERVED' => 0,
        'OPEN' => 1,
        'CLOSED' => 2,
    ],

    // 大会名を指定
    'TOURNAMENT' => [
        0 => 'J1リーグ',
        1 => '天皇杯',
        2 => 'ルヴァンカップ',
    ],

    // 大会名の番号
    'TOURNAMENT_NUMBER' => [
        'J1' => 0,
        'TENNOHAI' => 1,
        'LEVAIN' => 2,
    ],

    'TOURNAMENT_SUB' => [
        // 天皇杯のサブカテゴリを指定
        1 => [
            1 => '1回戦',
            2 => '2回戦',
            3 => '3回戦',
            4 => '4回戦',
            5 => 'ラウンド16',
            6 => '準々決勝',
            7 => '準決勝',
            8 => '決勝',
        ],
        // ルヴァンカップのサブカテゴリを指定
        2 => [
            0 => 'グループステージ',
            1 => 'プレーオフステージ',
            2 => '準々決勝',
            3 => '準決勝',
            4 => '決勝',
        ],
    ],

    // アンケートの選択肢に応じた番号
    'SURVEY' => [
        'CHOICE1' => 1,
        'CHOICE2' => 2,
        'CHOICE3' => 3,
        'CHOICE4' => 4,
        'CHOICE5' => 5,
    ],

    // URLの正規表現
    'REGEX' => [
        'URL' => '/((?:https?|ftp):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/',
        'REPLACED_URL' => '<a href="$0" target="_blank">$0</a>',
    ],
];