<?php

/*
既存のテーブルを削除する。
開くだけじゃなくpassを入力して削除することに注意！
逆に事故ることはほぼない・・・はず。
byおおくま
*/

//ここで自分のDBをログイン
$dsn = 'mysql:***';
$user = '***';
$password = '***';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

if(isset($_POST["pass"])){
  $pass = $_POST["pass"];
  if(strcmp($pass,"1111")==0){

//テーブル名を記入すること
  $sql = 'drop table if exists keiziban';

  $stmt = $pdo -> query($sql);
  echo "delete<br>";
}else{echo "パスワードが違うため削除できません<br>";}
}

echo "<hr>passは「1111」";
 ?>

 <!DOCTYPE html>
 <html lang="ja">
   <head>
     <meta charset="utf-8">
     <title></title>
   </head>
   <body>
     <form method="post">
       <input type="text" name="pass">
     </form>
   </body>
 </html>
