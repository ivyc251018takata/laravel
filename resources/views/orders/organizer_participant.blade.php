<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>参加者の注文</title>
</head>
<body>

<h1>{{ $participant->nickname }}の注文</h1>

<h2>{{ $party->name }}</h2>

@if ($orders->isEmpty())

    <p>まだ注文はありません。</p>

@else

    @foreach ($orders as $order)

        <div>
            <h3>{{ $order->item_name }}</h3>

            <p>
                数量：{{ $order->quantity }}
            </p>

            <p>
                単価：
                @if ($order->unit_price !== null)
                    {{ $order->unit_price }}円
                @else
                    未設定
                @endif
            </p>

            @if ($order->memo)
                <p>
                    備考：{{ $order->memo }}
                </p>
            @endif

            <p>
                状態：
                @if ($order->status === 0)
                    未確認
                @elseif ($order->status === 1)
                    承認済み
                @elseif ($order->status === 2)
                    差し戻し
                @endif
            </p>

            @if ($order->status === 2 && $order->reject_reason)
                <p>
                    差し戻し理由：{{ $order->reject_reason }}
                </p>
            @endif
        </div>

        <hr>

    @endforeach

@endif

<p>
    <a href="{{ route('organizer.participants.index') }}">
        <button type="button">参加者一覧に戻る</button>
    </a>
</p>

<p>
    <a href="{{ route('organizer.orders.index') }}">
        <button type="button">注文一覧を見る</button>
    </a>
</p>

</body>
</html>