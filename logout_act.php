<!-- ログアウト用の動作ページ -->

<?php
session_start();
require_once("funcs.php");

//SESSIONを初期化（空っぽにする）
$_SESSION = [];

//Cookieに保存してある"SessionIDの保存期間を過去にして破棄
if (isset($_COOKIE[session_name()])) { //session_name()は、セッションID名を返す関数
    setcookie(session_name(), '', time() - 42000, '/');
}

//サーバ側での、セッションIDの破棄
session_destroy();

header("Location: login.php");
exit();

?>
