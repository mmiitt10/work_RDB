<?php
// 共通準備
session_start();
require_once('funcs.php');
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

// コンテンツ情報を抽出
$stmt3 = $pdo->prepare("SELECT * FROM contents WHERE u_id = :u_id");
$stmt3->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_INT);
$stmt3->execute();
$results3 = $stmt3->fetchAll();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title><?php echo h($row2['u_name']) ?>さんの詳細ページ</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
        .profile, .content {
            border: 1px solid #ddd;
            margin-bottom: 10px;
            padding: 10px;
        }
        .contents {margin-top: 20px;}
    </style>
</head>
<body>
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
    <main>
        <!-- 個人情報表示 -->
        <div class="profile">
            <h2>プロフィール情報</h2>
            <p>名前: <?php echo h($row2['u_name']) ?></p>
            <p>生年月日: <?php echo h($row2['birthday']) ?></p>
            <p>所属企業: <?php echo h($row2['company']) ?></p>
            <p>役職: <?php echo h($row2['position']) ?></p>
            <p>自己紹介: <?php echo h($row2['introduction']) ?></p>
            <p>関心があるテーマ（業種）: <?php echo h($row2['industry_category']) ?></p>
            <p>関心があるテーマ（分野）: <?php echo h($row2['function_category']) ?></p>
            <p>職務経歴: <?php echo h($row2['resume']) ?></p>
        </div>

        <!-- 登録コンテンツ表示 -->
        <div class="contents">
            <h2>登録コンテンツ</h2>
            <?php foreach ($results3 as $row): ?>
                <div class="content">
                    <p>カテゴリ: <?php echo h($row['con_category'])?></p>
                    <p>コンテンツ名: <?php echo h($row['con_input_name']) ?></p>
                    <p>タイトル: <?php echo h($row['con_title']) ?></p>
                    <p>詳細: <?php echo h($row['con_detail']) ?></p>
                    <p>URL: <?php echo h($row['con_url']) ?></p>
                    <!-- その他のコンテンツ情報があればここに追加 -->
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>