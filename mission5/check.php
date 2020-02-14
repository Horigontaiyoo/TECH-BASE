<?php
/*
諸々を確認する際に使えるプログラム。
ちょっとコードをいじる必要あり！！
byおおくま
*/

//ここで自分のDBをログイン
$dsn = 'mysql:***;';
$user = 'tb-***';
$password = '****';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//自分のIDにある全てのテーブル名を確認・表示する。
$sql ='SHOW TABLES';
$result = $pdo -> query($sql);
foreach ($result as $row){
  echo $row[0];
  echo '<br>';
}
echo "<hr>";

//指定したテーブル名の構成、どんな項目がありそれにどんなオプションを付けているか表示
//確認したいテーブル名を指定すること！！！！
$sql ='SHOW CREATE TABLE ここにテーブル名';
	$result = $pdo -> query($sql);
	foreach ($result as $row){
		echo $row[1];
	}
	echo "<hr>";

//指定したテーブルに何が入っているか、そもそもデータ入力ができているか確認
//確認したいテーブル名を指定すること！！
  $sql = 'SELECT * FROM ここにテーブル名';
  	$stmt = $pdo->query($sql);
  	$results = $stmt->fetchAll();

//要注意！！！CREATEした時の項目名(＝カラム名)に変えること！同じとは限らない！
			foreach ($results as $key => $value) {
			  echo $value["ここid"].">>";
			  echo $value["ここname"].">>";
			  echo $value["ここcomment"].">>";
			  echo $value["ここdate_time"].">>";
			  echo $value["ここpass"].">>"."<br><hr>";
  	  }
 ?>
