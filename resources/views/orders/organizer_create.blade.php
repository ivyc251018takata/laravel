<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>幹事の注文登録</title>
    @vite(['resources/css/app.css'])
</head>
<body>

<h1>幹事の注文登録</h1>

<form action="{{ route('organizer.orders.store') }}" method="POST">
    @csrf

    <div>
        <label>商品名</label><br>
        <input type="text" name="item_name" value="{{ old('item_name') }}">

        @error('item_name')
            <p>{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label>数量</label><br>
        <input type="number" name="quantity" value="{{ old('quantity', 1) }}" min="1">

        @error('quantity')
            <p>{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label>単価</label><br>
        <input type="number" name="unit_price" value="{{ old('unit_price') }}" min="0">

        @error('unit_price')
            <p>{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label>備考</label><br>
        <textarea name="memo">{{ old('memo') }}</textarea>

        @error('memo')
            <p>{{ $message }}</p>
        @enderror
    </div>

    <button type="submit">注文を登録する</button>
</form>

<p>
    <a href="{{ route('organizer.orders.index') }}">
        <button type="button">注文一覧へ戻る</button>
    </a>
</p>

</body>
</html>