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
 <form method="POST" action="">
 <p>
<label> メニュー画像投稿<label/><br/>
画像ファイルをアップロードしてください。</br>
<input type="file" name="menu">
</p>
<p>
カンマ','等は使用せず、半角数字のみで入力してください。</br>
<label> 合計距離(m)<label/>
<input type="text" name="distance"/></br>
<label> 合計時間(分)<label/>
<input type="text" name="time"/></br>
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
<input type="submit" name="upload" value="投稿"/>
</form>
</body>
</html>
 
 