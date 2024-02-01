
<?php
session_start();
require_once('funcs.php');

//1. POSTデータ取得
$con_id=$_POST["con_id"];
$con_category=$_POST["con_category"];
$con_input_name=$_POST["con_input_name"];
$con_title=$_POST["con_title"];
$con_detail=$_POST["con_detail"];
$con_url=$_POST["con_url"];

//2. DB接続します
$pdo = db_conn();

//３．データ登録SQL作成

// フォームに入力された文字をそのままSQLに突っ込むと、問題がある場合がある。それを防ぐため、情報を仮の箱に一度入れたうえで（バインド関数）、それをSQLとする

$stmt = $pdo->prepare(
    'UPDATE contents
    SET u_id=:u_id,con_id=:con_id,con_category=:con_category,con_input_name=:con_input_name,con_title=:con_title,con_detail=:con_detail,con_url=:con_url
    where con_id=:con_id
    ');
$stmt->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_INT);
$stmt->bindValue(':con_id', $con_id, PDO::PARAM_STR);
$stmt->bindValue(':con_category', $con_category, PDO::PARAM_STR);
$stmt->bindValue(':con_input_name', $con_input_name, PDO::PARAM_STR);
$stmt->bindValue(':con_title', $con_title, PDO::PARAM_STR);
$stmt->bindValue(':con_detail', $con_detail, PDO::PARAM_STR);
$stmt->bindValue(':con_url', $con_url, PDO::PARAM_STR);
$status = $stmt->execute(); //実行

if($status === false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit('ErrorMessage:'.$error[2]);
}else{
  header("Location:mypage_select.php");
}

?>