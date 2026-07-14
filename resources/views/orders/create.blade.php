<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>注文する</title>
</head>
<body>

<h1>注文する</h1>

<form action="{{ route('orders.store') }}" method="POST">
    @csrf

    <div>
        <label>商品名</label><br>
        <input type="text" name="item_name">
    </div>

    <br>

    <div>
        <label>数量</label><br>
        <input type="number" name="quantity" value="1" min="1">
    </div>

    <br>

    <div>
        <label>単価</label><br>
        <input type="number" name="unit_price">
    </div>

    <br>

    <div>
        <label>備考</label><br>
        <textarea name="memo"></textarea>
    </div>

    <br>

    <button type="submit">
        注文する
    </button>

</form>

</body>
</html>