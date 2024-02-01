<?php
function db_conn(){
    try {
        $pdo = new PDO('mysql:dbname=test_profile;charset=utf8;host=localhost','root',"");
        return $pdo;
      } catch (PDOException $e) {
        exit('DBConnectError:'.$e->getMessage());
      };
}

function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

function chk_ssid() {
  if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()) {
      header('Location:login.php'); // ログインページへリダイレクト
      exit("User is not logged in.");
  }else{
      session_regenerate_id(true);
      $_SESSION["chk_ssid"] = session_id(); // 正しいIDで更新
  }
}

?>