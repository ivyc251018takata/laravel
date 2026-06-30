<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>宴会作成</title>
</head>
<body>

<h1>宴会作成</h1>

<form action="{{ route('parties.store') }}" method="POST">
    @csrf

    <div>
        <label>宴会名</label>
        <input type="text" name="name" required>
    </div>

    <div>
        <label>テーブル番号</label>
        <input type="text" name="table_number">
    </div>

    <div>
        <label>備考</label>
        <textarea name="memo"></textarea>
    </div>

    <button type="submit">
        作成
    </button>

</form>

</body>
</html>