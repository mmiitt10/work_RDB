<?php
session_start();
require_once("funcs.php");
chk_ssid();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>コンテンツ登録</title>
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
                <a class="navbar-brand" href="mypage_select.php">マイページ</a>
                <a class="navbar-brand" href="logout_act.php">ログアウト</a>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->
    <p>ようこそ<?php echo h($_SESSION['u_name'])?>さん。読んだWeb記事を登録してください</p>
    <form method="post" action="con_insert.php">
        <input type="hidden" name="con_category" >
        <input type="hidden" name="con_input_name" >
        <input type="hidden" name="con_title" >
        <input type="hidden" name="con_detail" >
        <label>コンテンツのURL<input type="text" name="con_url"></label><br>
        <label><input type="hidden" name="con_id"></label><br>
        <button type="submit" class="btn btn-primary">送信</button>
    </form>
    <!-- Main[End] -->
</body>
</html>
