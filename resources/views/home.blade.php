<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>宴会注文アプリ</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<h1>宴会注文アプリ</h1>

@if ($organizerParty)

    <hr>

    <h2>以前の宴会</h2>

    <p>
        宴会名：{{ $organizerParty->name }}
    </p>

    <p>
        参加コード：
        <code id="home-join-code">{{ $organizerParty->join_code }}</code>
        <button
            type="button"
            class="copy-button"
            data-copy-target="home-join-code"
        >コピー</button>
    </p>

    <a href="{{ route('organizer.participants.index') }}">
        <button type="button">以前の宴会に戻る</button>
    </a>

@endif


@if ($participant)

    <hr>

    <h2>以前の参加情報</h2>

    <p>
        参加者名：{{ $participant->nickname }}
    </p>

    <a href="{{ route('orders.index') }}">
        <button type="button">自分の注文を見る</button>
    </a>

@endif

<h1>宴会注文管理</h1>

<p>
    <a href="{{ route('parties.create') }}">
        <button type="button">宴会を作成する</button>
    </a>
</p>

<p>
    <a href="{{ route('participants.create') }}">
        <button type="button">宴会に参加する</button>
    </a>
</p>

</body>
</html>