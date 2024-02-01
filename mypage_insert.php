
<?php
session_start();
require_once('funcs.php');

//1. POSTデータ取得
$u_name=$_POST["u_name"];
$birthday=$_POST["birthday"];
$company=$_POST["company"];
$position=$_POST["position"];
$industry_category=$_POST["industry_category"];
$function_category=$_POST["function_category"];
$resume=$_POST["resume"];
$introduction=$_POST["introduction"];

//2. DB接続します
$pdo = db_conn();

//３．データ登録SQL作成

// フォームに入力された文字をそのままSQLに突っ込むと、問題がある場合がある。それを防ぐため、情報を仮の箱に一度入れたうえで（バインド関数）、それをSQLとする

$stmt = $pdo->prepare(
    'INSERT INTO profile(u_id,u_name,birthday,company,position,industry_category,function_category,resume,introduction)
    VALUES(:u_id,:u_name,:birthday,:company,:position,:industry_category,:function_category,:resume,:introduction);
    ');
$stmt->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_INT);
$stmt->bindValue(':u_name', $u_name, PDO::PARAM_STR);
$stmt->bindValue(':birthday', $birthday, PDO::PARAM_STR);
$stmt->bindValue(':company', $company, PDO::PARAM_STR);
$stmt->bindValue(':position', $position, PDO::PARAM_STR);
$stmt->bindValue(':industry_category', $industry_category, PDO::PARAM_STR);
$stmt->bindValue(':function_category', $function_category, PDO::PARAM_STR);
$stmt->bindValue(':resume', $resume, PDO::PARAM_STR);
$stmt->bindValue(':introduction', $introduction, PDO::PARAM_STR);
$status = $stmt->execute(); //実行

if($status === false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit('ErrorMessage:'.$error[2]);
}else{
  header("Location:mypage_select.php");
}

?>