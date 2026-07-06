<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>宴会に参加</title>
</head>
<body>

<h1>宴会に参加</h1>

<form action="{{ route('participants.store') }}" method="POST">
    @csrf

    <div>
        <label>参加コード</label><br>
        <input
            type="text"
            name="join_code"
            value="{{ old('join_code') }}"
        >

        @error('join_code')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <br>

    <div>
        <label>ニックネーム</label><br>
        <input
            type="text"
            name="nickname"
            value="{{ old('nickname') }}"
        >

        @error('nickname')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <br>

    <div>
        <label>備考</label><br>

        <textarea
            name="memo"
        >{{ old('memo') }}</textarea>

        @error('memo')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <br>

    <button type="submit">
        参加する
    </button>

</form>

</body>
</html>