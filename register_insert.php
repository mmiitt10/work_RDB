<!-- 会員登録用の登録動作ページ -->

<?php
require_once('funcs.php');

//1. POSTデータ取得
$u_mail=$_POST["u_mail"];
$u_pass=$_POST["u_pass"];

//2. DB接続します
$pdo = db_conn();

//３．データ登録SQL作成

// フォームに入力された文字をそのままSQLに突っ込むと、問題がある場合がある。それを防ぐため、情報を仮の箱に一度入れたうえで（バインド関数）、それをSQLとする

// 1. SQL文を用意
$stmt = $pdo->prepare("
  INSERT INTO 
    useradmin(u_id,u_mail,u_pass,life_flg,u_indate)
  VALUES
    (NULL,:u_mail,:u_pass,1,sysdate())
    ");

//  2. バインド変数を用意
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR

$stmt->bindValue(':u_mail', $u_mail, PDO::PARAM_STR);
$stmt->bindValue(':u_pass', $u_pass, PDO::PARAM_STR);

//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if($status === false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit('ErrorMessage:'.$error[2]);
}else{
  header("Location:login.php");
}

?>
