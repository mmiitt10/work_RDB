
<?php
session_start();
require_once("funcs.php");
chk_ssid();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>会員情報登録</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body>

    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <a class="navbar-brand" href="thread.php">スレッド</a>
                <a class="navbar-brand" href="book_register.php">本を登録する</a>
                <a class="navbar-brand" href="con_register.php">その他のコンテンツを登録する</a>
                <a class="navbar-brand" href="logout_act.php">ログアウト</a>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->
    インプットマネジメントへようこそ！<br>
    あなたについて詳しく教えてください<br>
    <form method="post" action="mypage_insert.php">
        <label>氏名<input type="text" name="u_name"></label><br>
        <label>生年月日<input type="date" name="birthday"></label><br>
        <label>現在の勤務先<input type="text" name="company"></label><br>
        <label>役職<input type="text" name="position"></label><br>
        <label>関心のあるテーマ（業界）<input type="text" name="industry_category"></label><br>
        <label>関心のあるテーマ（分野）<input type="text" name="function_category"></label><br>
        <label>職務経歴<input type="text" name="resume"></label><br>
        <label>自己紹介<input type="text" name="introduction"></label><br>
        <button type="submit" class="btn btn-primary">送信</button>
    </form>
    <!-- Main[End] -->
</body>

</html>
