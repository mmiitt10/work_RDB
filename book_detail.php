<?php
session_start();
require_once("funcs.php");
chk_ssid();

// 書籍IDを取得
$book_id = isset($_GET['id']) ? $_GET['id'] : '';
$book_detail = null;
$save_error = '';

if ($book_id) {
    // Google Books APIのURL
    $url = "https://www.googleapis.com/books/v1/volumes/" . urlencode($book_id);

    // APIからのレスポンスを取得
    $response = file_get_contents($url);

    // レスポンスをデコード
    $book_detail = json_decode($response);
}

if (!$book_detail) {
    echo "書籍の情報を取得できませんでした。";
    exit;
}

// ここから先は $book_detail を使用して書籍情報を表示
$volumeInfo = $book_detail->volumeInfo;
// 以下、HTMLコードを続ける
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>『<?php echo h($volumeInfo->title)?>』の詳細ページ</title>
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
                <a class="navbar-brand" href="con_register.php">その他のコンテンツを登録する</a>
                <a class="navbar-brand" href="mypage_select.php">マイページ</a>
                <a class="navbar-brand" href="logout_act.php">ログアウト</a>            
            </div>
        </nav>
    </header>
    <!-- Head[End] -->
    <main>
        <?php if (isset($volumeInfo)): ?>
            <h1><?php echo h($volumeInfo->title); ?></h1>
            <?php if (isset($volumeInfo->imageLinks) && isset($volumeInfo->imageLinks->thumbnail)): ?>
                <img src="<?php echo h($volumeInfo->imageLinks->thumbnail); ?>" alt="<?php echo h($volumeInfo->title); ?>">
            <?php else: ?>
                <p>画像が利用できません</p>
            <?php endif; ?>
            <p>著者: <?php echo isset($volumeInfo->authors) ? implode(', ', $volumeInfo->authors) : '著者不明'; ?></p>
            <p>発売日: <?php echo isset($volumeInfo->publishedDate) ? h($volumeInfo->publishedDate) : '日付不明'; ?></p>
            <p>カテゴリ: <?php echo isset($volumeInfo->categories) ? implode(', ', $volumeInfo->categories) : 'カテゴリなし'; ?></p>
            <p>説明: <?php echo isset($volumeInfo->description) ? h($volumeInfo->description) : '説明なし'; ?></p>

            <!-- フォーム -->
            <form action="book_insert.php" method="post">
                <input type="hidden" name="book_id" value="<?php echo h($book_id); ?>">
                <label>タイトル<input type="text" name="con_title"></label><br>
                <label>内容<input type="text" name="con_detail"></label><br>
                <button type="submit">登録する</button>
            </form>

            <?php if ($save_error): ?>
                <p><?php echo h($save_error); ?></p>
            <?php endif; ?>
        <?php else: ?>
            <p>書籍の情報を取得できませんでした。</p>
        <?php endif; ?>
    </main>
</body>
</html>
