<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>注文一覧</title>
    @vite(['resources/css/app.css'])
</head>
<body>

<h1>注文一覧</h1>

<h2>{{ $party->name }}</h2>

<h2>宴会全体の金額</h2>

<p>
    全注文の合計：
    {{ number_format($totalAmount) }}円
</p>

<p>
    承認済み注文の合計：
    {{ number_format($approvedAmount) }}円
</p>

<h2>注文の状態</h2>

<p>未確認：{{ $pendingCount }}件</p>
<p>承認済み：{{ $approvedCount }}件</p>
<p>差し戻し：{{ $rejectedCount }}件</p>

<p>
    <a href="{{ route('organizer.orders.create') }}">
        <button type="button">自分の注文を入力する</button>
    </a>
</p>

@if ($unpricedOrders->isNotEmpty())

    <p>
        金額未設定の注文が
        {{ $unpricedOrders->count() }}件あります。
    </p>

@endif

@if ($unpricedOrders->isNotEmpty())

    <h3>金額未設定の注文</h3>

    @foreach ($unpricedOrders as $order)

        <p>
            {{ $order->participant->nickname }}：
            {{ $order->item_name }}
            × {{ $order->quantity }}
        </p>

    @endforeach

@endif

<h2>参加者ごとの合計</h2>

@foreach ($participants as $participant)

    <p>
        {{ $participant->nickname }}：
        {{ number_format($participantTotals[$participant->id] ?? 0) }}円
    </p>

@endforeach



@if ($orders->isEmpty())

    <p>まだ注文はありません。</p>

@else

    @foreach ($orders as $order)

        <div>
            <h3>
                参加者：{{ $order->participant->nickname }}
            </h3>

            <p>
                商品名：{{ $order->item_name }}
            </p>

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

            @if ($order->status === 0 || $order->status === 2)

                <form
                    action="{{ route('organizer.orders.approve', $order) }}"
                    method="POST"
                >
                    @csrf

                    <button type="submit">
                        承認する
                    </button>
                </form>

            @endif

            @if ($order->status === 0 || $order->status === 1)

                <form
                    action="{{ route('organizer.orders.reject', $order) }}"
                    method="POST"
                >
                    @csrf

                    <input
                        type="text"
                        name="reject_reason"
                        placeholder="差し戻し理由"
                    >

                    @error('reject_reason')
                        <p>{{ $message }}</p>
                    @enderror

                    <button type="submit">
                        差し戻す
                    </button>
                </form>

            @endif

        </div>

        <hr>

    @endforeach

@endif

<p>
    <a href="{{ route('organizer.participants.index') }}">
        <button type="button">参加者一覧を見る</button>
    </a>
</p>

</body>
</html>