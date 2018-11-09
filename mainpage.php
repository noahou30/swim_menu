<?php
session_start();
$id=$_SESSION['id'];
$name=$_SESSION['name'];
echo "ようこそ".$name."さん。".'<br>';
echo "ユーザーID".$id."でログイン中です。";
?>