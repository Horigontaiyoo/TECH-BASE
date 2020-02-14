<?php
//データベース接続設定
$dsn='mysql:***';
$user='***';
$password='***';
$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
//もし"horigon"テーブルが存在していない場合新しく作るよ！
$sql="CREATE TABLE IF NOT EXISTS horigon"
." ("
//idは数字でオートで増えるよ。これは絶対的だよ！
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name char(32),"
."comment TEXT"
.");";
//queryは実行するという意味
$stmt=$pdo->query($sql);
//再代入して上書きされる。
//SHOW TABLESはつくったテーブル名の一覧が表示される。全て！
$sql ='SHOW TABLES';
$result = $pdo -> query($sql);
//$resultテーブルの中の$rowに含まれている$row[0]の値を繰り返ししたい。（テーブル名のみ）
foreach ($result as $row){
  echo '$row[0]'.$row[0];
  echo '$row[1]'.$row[1];
  echo '<br>';
}
echo "<hr>";
//データの設定を表示させる。設定のため何を入力していたとしても設定は変わらない。
$sql ='SHOW CREATE TABLE tbtest';
$result = $pdo -> query($sql);
foreach ($result as $row){
  echo '「デバック」$row[0]:'.$row[0]."<br>";
  echo '「デバック」$row[1]:'.$row[1]."<br>";
  echo '「デバック」$row[2]:'.$row[2]."<br>";
}
echo "<hr>";

//新規データを入力する処理⇒内容をいじる処理だからprepare
//「名前とコメントを新規で書き込んでください。」
$sql = "INSERT INTO tbtest (name, comment) VALUES (:name, :comment);";
//
$stmt = $pdo -> prepare($sql);
$name = 'ほりごん';
$comment = 'やっほー！';
//PDOは入る内容が文字なのか数字なのか指定している。
//STR:文字　INT：数字
// 「=」代入 「->」これを使って　という意味
$stmt -> bindValue(':name', $name, PDO::PARAM_STR);
$stmt -> bindValue(':comment', $comment, PDO::PARAM_STR);
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
//編集する場合
$id = 1; //変更する投稿番号
$name = "ookuma";
$comment = "kkkkkkk"; //変更したい名前、変更したいコメントは自分で決めること
$sql = 'update tbtest set name=:name,comment=:comment where id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':name', $name, PDO::PARAM_STR);
$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$id = 2;
$sql = 'delete from tbtest where id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();





 ?>
