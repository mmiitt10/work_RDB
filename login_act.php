<!-- ログイン用の動作ページ -->

<?php
session_start();
require_once('funcs.php');

//POST値を受け取る
$u_mail=$_POST["u_mail"];
$u_pass=$_POST["u_pass"];

//1.  DB接続します
$pdo = db_conn();

//2. データ登録SQL作成
// gs_user_tableに、IDとWPがあるか確認する。
$sql="SELECT * FROM useradmin WHERE u_mail=:u_mail AND u_pass=:u_pass";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':u_mail', $u_mail ,PDO::PARAM_STR);
$stmt->bindValue(':u_pass', $u_pass ,PDO::PARAM_STR);
$status = $stmt->execute();

//3. SQL実行時にエラーがある場合STOP
if($status === false){
    sql_error($stmt);
}

//4. 抽出データ数を取得（該当するデータのみ取得）
$val = $stmt->fetch();

//if(password_verify($u_pass, $val['u_pass'])){ //* PasswordがHash化の場合はこっちのIFを使う
if( $val['u_id'] != ''){
    // セッションそのもののデータの中に、データを挿入する
    // セッションそのものにセッションidを付与
    $_SESSION['chk_ssid']=session_id();
    // セッションにログインしている人の名前を挿入する
    $_SESSION['u_name'] = $val['u_name'];
    // セッションにログインしているユーザーのIDを挿入する
    $_SESSION['u_id'] = $val['u_id'];
    header('Location:mypage_select.php');
    exit();
}else{
    //Login失敗時(Logout経由)
    header('Location:login.php');
    exit();
}

?>