<?php
$dsn='mysql:dbname=tt_461_99sv_coco_com;host=localhost';
$user='tt-461.99sv-coco';
$password='Ku6vA7Gz';
$pdo=new PDO($dsn,$user,$password,
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)
);

session_start();
$id=$_SESSION['id'];

if(empty($id)){
    echo "ログインユーザーのみ利用できます。".'</br>'.
                '<a href="mainpage.php">メインページへ戻る</a>';
                exit();
}
//ログイン時のみ
if(!empty($id)){
    $id=$_POST['id'];
    $distance=$_POST['distance'];
    $time=$_POST['time'];
    $age==$_POST['age'];
    $sex=$_POST['sex'];
    $level=$_POST['id'];
    $aim=$_POST['aim'];
    $comment=$_POST['comment'];
    if(isset($_POST['upload'])){
    $upfile=$_FILES['menu'];
    if(empty($distance) or empty($time)){
        $hissu="合計距離と合計時間は必須入力です。";
    }
    if(!preg_match("/^[0-9]+$/", $distance) and !preg_match("/^[0-9]+$/", $time)){
        $hissu="合計距離と合計時間は半角数字で入力してください。";
    }
    else{
        if(empty($upfile)){
            $error="ファイルを選択してください。";
        }
        if(isset($upfile)){
            //アップロードエラー処理文　
            if($upfile['error'] > 0) {
                $error="ファイルアップロードに失敗しました。";
            }
            $tmp_name = $upfile['tmp_name'];
             //ファイルタイプチェック
            if(!preg_match('/\.gif$|\.png$|\.jpg$|\.jpeg$/i', $tmp_name)){
                $error="ファイルタイプエラー".'<br>'."ファイル拡張子はjpg,jpeg,png,gifのいずれかにしてください。";
            }
            if(preg_match('/\.gif$|\.png$|\.jpg$|\.jpeg$/i', $tmp_name)){
                $bname = basename($_FILES['name']);
                $name = mb_convert_encoding($bname, "UTF-8", "AUTO");
       
                //パスを発行して違う変数に入れる
                $path = "../menu/$name";
                $move=move_uploaded_file($tmp_name, $path);
                if($move==false){
                 $error="ファイルの移動に失敗しました。";
                }
             if($move !==false){
                try{
                    $sql=$pdo->prepare('INSERT INTO swim_menu (id,menu,distance,time,age,sex,level,aim,comment) VALUES (:id,:menu,:distance,:time,:age,:sex,:level,:aim,:comment)');
                    $sql->bindParam(':id',$id,PDO::PARAM_STR);
                    $sql->bindParam(':menu',$path,PDO::PARAM_STR);
                    $sql->bindParam(':distance',$distance,PDO::PARAM_INT);
                    $sql->bindParam(':time',$time,PDO::PARAM_INT);
                    $sql->bindParam(':age',$age,PDO::PARAM_STR);
                    $sql->bindParam(':sex',$sex,PDO::PARAM_STR);
                    $sql->bindParam(':level',$level,PDO::PARAM_STR);
                    $sql->bindParam(':aim',$aim,PDO::PARAM_STR);
                    $sql->bindParam(':comment',$comment,PDO::PARAM_STR);
                    $sql->execute();
                } catch (Exception $e){
                    if (isset($e)){
                        $error="データベースエラー";
                    }
                    else{$success="投稿完了しました。" ;
                            }
                            }
                }
                }
                            }
                            }
}
}

?>
    

<!DOCTYPE HTML>
<html lang="ja">
 <head>
 <meta http-equiv="content-type" charset="UTF-8">
 <title>投稿ページ</title>
 </head>
 <body>
 <!--ヘッダー-->
 <a href="mainpage.php">戻る</a>
 <!--ここから本体-->
 <?php echo $success.'</br></br>'; ?>
 <form method="POST" action="" enctype="multipart/form-data">
 <p>
<label> メニュー画像投稿<label/><br/>
画像ファイルをアップロードしてください。</br>
大きさは30000byteまで</br>
拡張子は.jpg,.png,.gifです。</br>
<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
<input type="file" name="menu" accept="image/*"></br>
<?php echo $error; ?>
</p>
<p>
カンマ','等は使用せず、半角数字のみで入力してください。</br>
<label> 合計距離(m)<label/>
<input type="text" name="distance"/></br>
<label> 合計時間(分)<label/>
<input type="text" name="time"/></br>
<?php echo $hissu; ?>
</p>
<p>
以下はメニュー使用者の属性情報を選択してください。</br>
<!--     スクロールで選択    -->
<label>年齢<label/>
<select name="age">
<option value="1">小学生以下</option>
<option value="2">中学生</option>
<option value="3">高校生</option>
<option value="4">18~24歳</option>
<option value="5">25~29歳</option>
<option value="6">30~34歳</option>
<option value="7">35~39歳</option>
<option value="8">40~44歳</option>
<option value="9">45~49歳</option>
<option value="10">50~54歳</option>
<option value="11">55~59歳</option>
<option value="12">60~64歳</option>
<option value="13">65~69歳</option>
<option value="14">70~74歳</option>
<option value="15">75~79歳</option>
<option value="16">80~84歳</option>
<option value="17">85~89歳</option>
<option value="18">90~94歳</option>
<option value="19">95~99歳</option>
<option value="20">100歳~</option>
</select>
&emsp;
<label>性別<label/>
<select name="sex">
<option value="m">男性</option>
<option value="f"> 女性</option>
<option value="mf">兼用</option>
</select>
&nbsp;
<label>レベル</label>
<select name="level">
<option value="beg">初級(育成区分,~泳力検定2級,趣味愛好者)</option>
<option value="mid">中級(大会出場選手,泳力検定1級以上)</option>
<option value="upp">上級(大会入賞レベル)</option>
<option value="top">トップスイマー(全国レベル以上)</option>
</select>
&nbsp;
<label>練習目的</label>
<select name="aim">
<option value="health">健康維持</option>
<option value="daily">通常練習</option>
<option value="precom">大会直前</option>
<option value="long">ディスタンス</option>
</select>
</p>
<p>
<label>コメント(任意入力)</label></br>
<textarea rows="4" cols="40" name="comment" placeholder="メニューや使用者に対する補足情報等があれば入力してください。"/></textarea></br>
<input type="submit" name="upload" value="投稿"/>
</form>
</body>
</html>
 
 