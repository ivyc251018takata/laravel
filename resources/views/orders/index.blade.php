<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>注文一覧</title>
    @vite(['resources/css/app.css'])
</head>
<body>

<h1>自分の注文一覧</h1>

@forelse ($orders as $order)

    <div>
        <h2>{{ $order->item_name }}</h2>

        <p>数量：{{ $order->quantity }}</p>

        <p>
            単価：
            @if ($order->unit_price !== null)
                {{ $order->unit_price }}円
            @else
                未設定
            @endif
        </p>

        @if ($order->memo)
            <p>備考：{{ $order->memo }}</p>
        @endif

        @if ($order->status === 0)

            <p>状態：未確認</p>

        @elseif ($order->status === 1)

            <p>状態：承認済み</p>

        @elseif ($order->status === 2)

            <p>状態：差し戻し</p>

            @if ($order->reject_reason)
                <p>
                    差し戻し理由：{{ $order->reject_reason }}
                </p>
            @endif

        @endif

        <a href="{{ route('orders.edit', $order) }}">
            編集
        </a>

        <form action="{{ route('orders.destroy', $order) }}" method="POST">
            @csrf
            @method('DELETE')

            <button type="submit">
                削除
            </button>
        </form>
    </div>

    <hr>

@empty

    <p>まだ注文はありません。</p>

@endforelse

<p>
    <a href="{{ route('orders.create') }}">
        <button type="button">注文を追加する</button>
    </a>
</p>

<p>
    <a href="{{ route('home') }}">
        <button type="button">ホームに戻る</button>
    </a>
</p>

</body>
</html>