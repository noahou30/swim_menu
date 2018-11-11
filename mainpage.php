<?php
session_start();
$id=$_SESSION['id'];
$name=$_SESSION['name'];
echo "ようこそ".$name."さん。".'<br>';
echo "ユーザーID：".$id."でログイン中です。";
?>
<!DOCTYPE html>
<html lang="ja">
 <head>
 <meta http-equiv="content-type" charset="UTF-8">
 <title>メインページ</title>
  </head>
 <body>
<a href="useronly.php">投稿ページへ</a>
</body>
</html>