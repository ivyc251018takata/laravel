<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>参加者一覧</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<h1>参加者一覧</h1>

<h2>{{ $party->name }}</h2>

<p>
    参加コード：
    <code id="organizer-join-code">{{ $party->join_code }}</code>
    <button
        type="button"
        class="copy-button"
        data-copy-target="organizer-join-code"
    >コピー</button>
</p>

@if ($party->table_number)
    <p>テーブル番号：{{ $party->table_number }}</p>
@endif

@if ($participants->isEmpty())

    <p>まだ参加者はいません。</p>

@else

    @foreach ($participants as $participant)

        <div>
            <h3>{{ $participant->nickname }}</h3>

            @if ($participant->memo)
                <p>メモ：{{ $participant->memo }}</p>
            @endif

            <p>
                <a href="{{ route('organizer.participants.orders', $participant) }}">
                    <button type="button">注文を見る</button>
                </a>
            </p>
        </div>

        <hr>

    @endforeach

@endif

<p>
    <a href="{{ route('organizer.orders.index') }}">
        <button type="button">注文一覧を見る</button>
    </a>
</p>

</body>
</html>