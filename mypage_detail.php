<?php
session_start();
require_once("funcs.php");
chk_ssid();

//1.  DB接続
$pdo = db_conn();

//２．データ取得SQL作成
// 会員情報を抽出
$stmt1 = $pdo->prepare("SELECT * FROM useradmin WHERE u_id = :u_id");
$stmt1->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_INT);
$stmt1->execute();
$results1 = $stmt1->fetchAll();
$row1=$results1[0];

// プロフィール情報を抽出
$stmt2 = $pdo->prepare("SELECT * FROM profile WHERE u_id = :u_id");
$stmt2->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_INT);
$stmt2->execute();
$results2 = $stmt2->fetchAll();
$row2= $results2[0];

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
                <a class="navbar-brand" href="mypage_select.php">マイページ</a>
                <a class="navbar-brand" href="logout_act.php">ログアウト</a>            
            </div>
        </nav>
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->
    <form method="post" action="mypage_update.php">
        <label>氏名<input type="text" name="u_name" value=<?= $row2["u_name"]?>></label><br>
        <label>生年月日<input type="date" name="birthday" value=<?= $row2["birthday"]?>></label><br>
        <label>現在の勤務先<input type="text" name="company" value=<?= $row2["company"]?>></label><br>
        <label>役職<input type="text" name="position" value=<?= $row2["position"]?>></label><br>
        <label>関心のあるテーマ（業界）<input type="text" name="industry_category" value=<?= $row2["industry_category"]?>></label><br>
        <label>関心のあるテーマ（分野）<input type="text" name="function_category" value=<?= $row2["function_category"]?>></label><br>
        <label>職務経歴<input type="text" name="resume" value=<?= $row2["resume"]?>></label><br>
        <label>自己紹介<input type="text" name="introduction" value=<?= $row2["introduction"]?>></label><br>
        <button type="submit" class="btn btn-primary">送信</button>
    </form>
    <!-- Main[End] -->
</body>

</html>
