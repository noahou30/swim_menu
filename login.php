<?php
$dsn='データベース名';
$user='ユーザーID';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password,
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)
);
?>

<?php 
//$sql="DROP TABLE user".";";
//$pdo->query($sql);
?>

<?php
//全データ消去
//$sql="TRUNCATE TABLE user".";";
//$pdo->query($sql);
?>

<?php
//$sql="CREATE TABLE user"
//."("
//."id char(32) UNIQUE,"
//."password char(32),"
//."name char(32) UNIQUE"
//.");";
//$stmt=$pdo->query($sql);
?>

<?php
session_start();
$login=$_POST['login'];
$id=$_POST['id'];
$password=$_POST['password'];
$error="";
if(isset($login)){
	if(empty($id)){
		$error="IDを入力してください";
	}
	if(empty($password)){
		$error="パスワードを入力してください";
	}
	if(!empty($id) and !empty($password)){
		$sql=$pdo->prepare('SELECT * FROM user WHERE id =:id');
		$sql->bindParam(':id',$id,PDO::PARAM_STR);
		$sql->execute();
		$result=$sql->fetch();
		$pass=$result['password'];
		$username=$result['name'];
		if($pass===$password){
			try{
			session_regenerate_id(true);
			$_SESSION['id']=$id;
			$_SESSION['name']=$username;
			header("Location:mainpage.php");
			exit();
			}
			catch(PDOException $e){
				if(!empty($e)){
					$error="ログインに失敗しました。";
				}
			}
		}
	}
}
?>		
	

<!DOCTYPE html>
<html lang="ja">
 <head>
 <meta http-equiv="content-type" charset="UTF-8">
  <title>ユーザーログイン</title>
  </head>
 <body>
 <p>
<h1>水泳メニュー掲示板</h1>
</p>
<p>
<h2>ログイン</h2>
<form method="POST" action="">
<label>ユーザーID<label/><br/>
	<input type="text" name="id"/><br />
<label>パスワード<label/><br/>
	<input type="password"  name="password"/><br />
	<input type="submit" name="login" value="ログイン"/>
	</form>
	</p>
<a href=""> ログインせずに利用する</a>
 <p>※検索機能・投稿機能は利用できません</p>
	</body>
	</html>



