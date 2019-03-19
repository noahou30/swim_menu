<?php
session_start();
 
header("Content-type: text/html; charset=utf-8");
 
//クロスサイトリクエストフォージェリ（CSRF）対策
$token = $_SESSION['token'];
 
//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');
 
?>
 
<!DOCTYPE html>
<html>
<head>
<title>水泳メニュー掲示板-メール登録画面</title>
<meta charset="utf-8">
</head>
<body>
<h1>メール登録画面</h1>
 <p>
 メール認証用のアドレスを入力してください。</br>
 flutyzine@gmail.comから登録用メールが届きます。
 </p>
<form action="registration_mail_check.php" method="post">
 
<p>メールアドレス：<input type="text" name="mail" size="50"></p>
 
<input type="hidden" name="token" value="<?=$token?>">
<input type="submit" value="登録する">
 
</form>

<p>
<a href="mainpage.php">メインページへ戻る</a>
</p>
 
</body>
</html>