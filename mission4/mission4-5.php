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

$sql ='SHOW CREATE TABLE tbtest';
$result = $pdo -> query($sql);
foreach ($result as $row){
  echo '$row[0]:'.$row[0]."<br>";
  echo $row[1];
}
echo "<hr>";

$sql = "INSERT INTO tbtest (name, comment) VALUES (:name, :comment);";
$stmt = $pdo -> prepare($sql);
$name = 'ほりごん';
$comment = 'やっほー！';
//PDOは入る内容が文字なのか数字なのか指定している。
//STR:文字　INT：数字
// 「=」代入 「->」これを使って　という意味
$stmt -> bindParam(':name', $name, PDO::PARAM_STR);
$stmt -> bindParam(':comment', $comment, PDO::PARAM_STR);
$stmt -> execute();

//「*」はallという意味。
//項目＝カラム SELECTですべての項目を選択。
//今行っている動作はSQL文。処理ではない。箱ではなくテーブル。
$sql = 'SELECT * FROM tbtest';
$stmt = $pdo->query($sql);
//fetchALLは$stmtを分解して綺麗に揃えてから$resultsに代入しているイメージ（正確な情報か分からない）
$lines = $stmt->fetchAll();
//連想配列＝配列の中に配列が入っているイメージ。
foreach ($lines as $line){
//配列は通常数字を入れるが、今回はカラム名を入力する。
echo $line['id'].',';
echo $line['name'].',';
echo $line['comment'].'<br>';
echo "<hr>";
}

 ?>
