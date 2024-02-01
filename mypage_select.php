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

// コンテンツ情報を抽出
$stmt3 = $pdo->prepare("SELECT * FROM contents WHERE u_id = :u_id");
$stmt3->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_INT);
$stmt3->execute();
$results3 = $stmt3->fetchAll();

// 最初のログイン時は会員情報登録を実施し、複数回目のログイン時は会員名をセッションに与える
if(!$row2 || empty($row2['u_name'])){
    header("Location: mypage_form.php");
    exit();
} else {
    // u_nameが設定されている場合はセッション情報にu_nameを挿入
    $_SESSION['u_name'] = $row2['u_name'];
}

// オンボーディングとして、コンテンツを登録していない人は、会員情報登録後に複数個のコンテンツを登録するようにしたい
// コンテンツを3つほど登録したら、指向が近い人が自動的にレコメンドされるイメージ
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title><?php echo h($row2['u_name']) ?>さんのマイページ</title>
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
            <form action="mypage_detail.php" method="post">
                <input type="submit" value="更新する">
            </form>
        </div>

        <!-- 登録コンテンツ表示 -->
        <div class="contents">
            <h2>登録コンテンツ</h2>
            <form action="book_register.php" method="post">
                <button type="submit" >読んだ本を登録する</button>
            </form>
            <form action="con_register.php" method="post">
                <button type="submit" >本以外のコンテンツを登録する</button>
            </form>
            <?php foreach ($results3 as $row): ?>
                <div class="content">
                    <p>カテゴリ: <?php echo h($row['con_category'])?></p>
                    <p>コンテンツ名: <?php echo h($row['con_input_name']) ?></p>
                    <p>タイトル: <?php echo h($row['con_title']) ?></p>
                    <p>詳細: <?php echo h($row['con_detail']) ?></p>
                    <p>URL: <?php echo h($row['con_url']) ?></p>

                    <!-- 更新ボタン -->
                    <form action="con_detail.php" method="post"> 
                        <input type="hidden" name="con_id" value="<?php echo h($row['con_id']); ?>">                       
                        <input type="submit" value="更新する">
                    </form>

                    <!-- 削除ボタン -->
                    <form action="con_delete.php" method="post">
                        <input type="hidden" name="con_id" value="<?php echo h($row['con_id']); ?>">                       
                        <input type="submit" value="削除する">
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>