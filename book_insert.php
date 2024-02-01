<?php
session_start();
require_once("funcs.php");
chk_ssid();

// POSTリクエストからデータを取得
$book_id = isset($_POST['book_id']) ? $_POST['book_id'] : '';
$con_title = isset($_POST['con_title']) ? $_POST['con_title'] : '';
$con_detail = isset($_POST['con_detail']) ? $_POST['con_detail'] : '';

// バリデーション
if (!$book_id || !$con_title ||!$con_detail) {
    echo "必要な情報が不足しています。";
    exit;
}

$pdo = db_conn();

// Google Books APIから書籍情報を取得
$url = "https://www.googleapis.com/books/v1/volumes/" . urlencode($book_id);
$response = file_get_contents($url);
$book_detail = json_decode($response);

if (!$book_detail) {
    echo "書籍の情報を取得できませんでした。";
    header("Location:book_register.php");
    exit;
}

$title = $volumeInfo->title;
$category = isset($volumeInfo->categories) ? implode(', ', $volumeInfo->categories) : '';
$book_url = $volumeInfo->infoLink ?? ''; // infoLinkが存在しない場合は空文字列を使用

// データベースへの挿入
$stmt = $pdo->prepare(
    'INSERT INTO contents(u_id,con_id,con_category,con_input_name,con_title,con_detail,con_url,con_indate)
    VALUES(:u_id,null,:con_category,:con_input_name,:con_title,:con_detail,:con_url,sysdate());
    ');
$stmt->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_INT);
$stmt->bindValue(':con_category', $category, PDO::PARAM_STR);
$stmt->bindValue(':con_input_name', "書籍", PDO::PARAM_STR);
$stmt->bindValue(':con_title', $con_title, PDO::PARAM_STR);
$stmt->bindValue(':con_detail', $con_detail, PDO::PARAM_STR);
$stmt->bindValue(':con_url', $book_url, PDO::PARAM_STR);
$status = $stmt->execute(); //実行
// 書籍情報の処理

if ($status == false) {
    sql_error($stmt);
} else {
    header('Location:mypage_select.php');
}
?>
