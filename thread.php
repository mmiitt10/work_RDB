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
$stmt2 = $pdo->prepare("SELECT * FROM profile");
$stmt2->execute();
$results2 = $stmt2->fetchAll();

// コンテンツ情報に紐づけるためにプロフィール情報を連想配列に格納
$profiles = [];
foreach ($results2 as $profile) {
    $profiles[$profile['u_id']] = $profile;
};

// コンテンツ情報を抽出
$stmt3 = $pdo->prepare("SELECT * FROM contents");
$stmt3->execute();
$results3 = $stmt3->fetchAll();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>スレッド</title>
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
                <a class="navbar-brand" href="book_register.php">本を登録する</a>
                <a class="navbar-brand" href="con_register.php">その他のコンテンツを登録する</a>
                <a class="navbar-brand" href="logout_act.php">ログアウト</a>
                <a class="navbar-brand" href="mypage_select.php">マイページ</a>
            </div>
        </nav>
    </header>
    <main>
        <!-- 投稿を表示 -->
        <div class="contents">
            <?php foreach ($results3 as $row): ?>
                <div class="content">
                <!-- 対応するプロフィール情報を取得 -->
                    <?php $profile = $profiles[$row['u_id']] ?? null;
                    if ($profile): ?>
                    <a href="">
                        <p>ユーザー名: <a href="user_page.php?u_id=<?php echo h($profile['u_id']); ?>"><?php echo h($profile['u_name']); ?></a></p>
                        <p>所属企業: <?php echo h($profile['company']); ?></p>
                        <p>役職: <?php echo h($profile['position']); ?></p>
                    <?php endif; ?>
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