<?php
$dsn='mysql:***';
$user='t***';
$password='***';
$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));

$sql="CREATE TABLE IF NOT EXISTS horigon"
." ("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name char(32),"
."comment TEXT"
.");";
//queryは実行するという意味
$stmt=$pdo->query($sql);
//再代入して上書きされる。
//SHOW TABLESはつくったテーブル名の一覧が表示される。
$sql ='SHOW TABLES';
$result = $pdo -> query($sql);
foreach ($result as $row){
  echo $row[0];
  echo '<br>';
}
echo "<hr>";
 ?>
