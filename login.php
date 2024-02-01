<!-- ログイン用のフロントページ -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="css/main.css" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
    <title>ログイン</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <a class="navbar-brand" href="register.php">会員登録</a>
            </div>
        </nav>
    </header>
    <!-- lLOGINogin_act.php は認証処理用のPHPです。 -->
    <form name="form1" action="login_act.php" method="post">
        <label>メールアドレス:<input type="text" name="u_mail"/></label><br>
        <label>パスワード:<input type="password" name="u_pass" /></label><br>
        <input type="submit" value="LOGIN" />
    </form>


</body>

</html>
