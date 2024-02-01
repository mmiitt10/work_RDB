<!-- 会員登録用のフロントページ -->

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>会員登録</title>
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
                <a class="navbar-brand" href="login.php">ログイン</a>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->
    メールアドレスとパスワードを入力してください
    <form method="post" action="register_insert.php">
        <label>メールアドレス<input type="text" name="u_mail"></label><br>
        <label>パスワード<input type="text" name="u_pass"></label><br>
        <button type="submit" class="btn btn-primary">送信</button>
    </form>
    <!-- Main[End] -->
</body>

</html>
