<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>注文編集</title>
    @vite(['resources/css/app.css'])
</head>
<body>

<h1>注文編集</h1>

<form action="{{ route('orders.update', $order) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>商品名</label><br>
        <input
            type="text"
            name="item_name"
            value="{{ old('item_name', $order->item_name) }}"
        >
    </div>

    <br>

    <div>
        <label>数量</label><br>
        <input
            type="number"
            name="quantity"
            min="1"
            value="{{ old('quantity', $order->quantity) }}"
        >
    </div>

    <br>

    <div>
        <label>単価</label><br>
        <input
            type="number"
            name="unit_price"
            min="0"
            value="{{ old('unit_price', $order->unit_price) }}"
        >
    </div>

    <br>

    <div>
        <label>備考</label><br>
        <textarea name="memo">{{ old('memo', $order->memo) }}</textarea>
    </div>

    <br>

    <button type="submit">
        更新する
    </button>

</form>

<p>
    <a href="{{ route('orders.index') }}">
        注文一覧へ戻る
    </a>
</p>

</body>
</html>