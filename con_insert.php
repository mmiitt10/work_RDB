<?php
session_start();
require_once('funcs.php');
chk_ssid();
setlocale(LC_CTYPE, "en_US.UTF-8");

//1. POSTデータ取得
$con_category   = $_POST['con_category'];
$con_input_name  = $_POST['con_input_name'];
$con_title  = $_POST['con_title'];
$con_detail = $_POST['con_detail'];
$con_url    = $_POST['con_url']; 

// Pythonスクリプトを実行してタイトルを取得
$con_title = shell_exec("python \"C:\\xampp\\htdocs\\test2\\get_title.py\" " . escapeshellarg($con_url));
$title = mb_convert_encoding($title, 'UTF-8', 'UTF-8');

// //2. DB接続します
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare(
    'INSERT INTO contents(u_id,con_id,con_category,con_input_name,con_title,con_detail,con_url,con_indate)
    VALUES(:u_id,null,:con_category,:con_input_name,:con_title,:con_detail,:con_url,sysdate());
    ');
$stmt->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_INT);
$stmt->bindValue(':con_category', $con_category, PDO::PARAM_STR);
$stmt->bindValue(':con_input_name', $con_input_name, PDO::PARAM_STR);
$stmt->bindValue(':con_title', $con_title, PDO::PARAM_STR);
$stmt->bindValue(':con_detail', $con_detail, PDO::PARAM_STR);
$stmt->bindValue(':con_url', $con_url, PDO::PARAM_STR);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    // 挿入されたレコードのIDを取得
    $con_id = $pdo->lastInsertId();
    // con_detail.phpにリダイレクトし、con_idをクエリパラメータとして渡す
    header("Location: con_detail.php?con_id=" . $con_id);
}

// // //３．データ登録SQL作成
// $stmt = $pdo->prepare(
//     'INSERT INTO pytest1(id,title)
//     VALUES(null,:title);
//     ');
// $stmt->bindValue(':title', $title, PDO::PARAM_STR);
// $status = $stmt->execute(); 
// //実行

// // //４．データ登録処理後
// if ($status == false) {
//     sql_error($stmt);
// } else {
//     header('Location:con_detail.php');
// }

?>
