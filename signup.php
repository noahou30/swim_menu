<!DOCTYPE html>
<html lang="ja">
 <head>
 <meta http-equiv="content-type" charset="UTF-8">
 <title>登録完了</title>
 </head>
 <body>
<?php
session_start();
?>
<p>
ようこそ<?php echo $_SESSION['name']; ?> さん！<br/>
ユーザーID <?php echo $_SESSION['id']; ?> で登録完了しました。<br/>
 <a href="mainpage.php"> ログインする</a>
</p>
</body>
</html>

