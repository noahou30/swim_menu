<?php
$dsn='mysql:dbname=****;host=****';
$user='****';
$password='****';
$pdo=new PDO($dsn,$user,$password,
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)
);

session_start();

//クロスサイトリクエストフォージェリ（CSRF）対策
$token = $_SESSION['token'];
 
//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

$newerror="";
if(empty($_GET)) {
	header("Location: registration_mail_form.php");
	exit();
}else{
	//GETデータを変数に入れる
	$urltoken = isset($_GET[urltoken]) ? $_GET[urltoken] : NULL;
	//メール入力判定
	if ($urltoken == ''){
		$error = "もう一度登録をやりなおして下さい。";
	}else{
		//例外処理を投げる（スロー）ようにする
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			//flagが0の未登録者・仮登録日から24時間以内
			$statement = $pdo->prepare("SELECT mail FROM pre_user WHERE urltoken=(:urltoken) AND flag =0 AND date > now() - interval 24 hour");
			$statement->bindValue(':urltoken', $urltoken, PDO::PARAM_STR);
			$statement->execute();
			
			//レコード件数取得
			$row_count = $statement->rowCount();
			
			//24時間以内に仮登録され、本登録されていないトークンの場合
			if( $row_count ==1){
				$mail_array = $statement->fetch();
				$mail = $mail_array[mail];
				$_SESSION['mail'] = $mail;
			}else{
				$error= "このURLはご利用できません。有効期限が過ぎた等の問題があります。もう一度登録をやりなおして下さい。";
			}
	}
echo $error;
if(isset($error)){
	exit();
}
}

//有効なメール認証だった場合
$register=$_POST["register"];
$newid=$_POST["newid"];
$newpass=$_POST["newpass"];
$newpass2=$_POST["newpass2"];
$newname=$_POST["newname"];

if(isset($register)){
	if(empty($newid) or empty($newpass) or empty($newpass2) or empty ($newname)){
		$newerror="フォーム内は全て必須入力です。";
	}
	if(!empty($newid) and !empty($newpass) and !empty($newname)){
    		if(!preg_match('/^[0-9a-zA-Z]{1,20}$/',$newid)){
    			$newerror= "ユーザーIDの形式が間違っています。"; 
    			}
			if(!preg_match('/^(?=.*?[0-9])(?=.*?[a-zA-Z])[0-9a-zA-Z]{6,}$/',$newpass)){
				$newerror= "パスワードの形式が間違っています。";
				}
	if($newpass!==$newpass2){
		$newerror="パスワードが一致しません。";
	}
	if(preg_match('/^[0-9a-zA-Z]{1,20}$/',$newid) and preg_match('/^(?=.*?[0-9])(?=.*?[a-zA-Z])[0-9a-zA-Z]{6,}$/',$newpass)){
	    //被りがなければINSERTする
	    $sql=$pdo->prepare('INSERT INTO user (id,password,name) VALUES (:id,:password,:name)');
	    $sql->bindParam(':id',$newid,PDO::PARAM_STR);
		$sql->bindParam(':password',$newpass,PDO::PARAM_STR);
		$sql->bindParam(':name',$newname,PDO::PARAM_STR);
		try {
			$sql->execute();
			session_start();
			$_SESSION['id']=$newid;
			$_SESSION['name']=$newname;
			header("Location: signup.php"); //登録完了画面に遷移
			exit();
			} 
			catch (PDOException $e){
				$error_code=$sql->errorCode();
				if($error_code == 23000)
				{$newerror="このIDまたはユーザー名は既に使用されています。";
				}
			}
	}
}
else{
    $newerror=  "登録するIDとパスワードを入力してください。";
}
} 
?>



<!DOCTYPE html>
<html lang="ja">
 <head>
 <meta http-equiv="content-type" charset="UTF-8">
 <title>新規登録</title>
 </head>
 <body>
<br />
<p>
<h1>水泳メニュー掲示板</h1>
</p>
<p>
<h2>新規ユーザー登録</h2>
<p>ユーザーIDは半角英数文字で入力してください。</p>
<p>パスワードは6文字以上で、半角英数字をそれぞれ1文字以上含めてください。</p>
 <form method="POST" action="">
  <label>ユーザー名<label/><br/>
  <input type="text" name="newname"/><br />
 <label>ユーザーID<label/><br/>
	<input type="text" name="newid"/><br />
<label>パスワード<label/><br/>
	<input type="password"  name="newpass"/><br />
<label>パスワード(確認用)<label/><br/>
	<input type="password"  name="newpass2"/><br />
	<input type="submit" name="register" value="登録"/>
 </form>
 <p> <?php echo $newerror ?> </p>
 </p>
 <a href=""> ログインせずに利用する</a>
 <p>※検索機能・投稿機能は利用できません</p>

