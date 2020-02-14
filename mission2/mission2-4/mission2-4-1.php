<?php
//・GET⇒データがURLで引き渡される
//・POST⇒データがURLで引き渡されない
$comment=$_POST["comment"];
$comment=trim($comment);
if(!empty($comment)&&$comment=="finish"){
  echo "おめでとう！";
}elseif(!empty($comment)){
  echo $comment."を受け付けました";}

$filename="mission2-4-1.txt";
$fp=fopen($filename,"a");
fwrite($fp,$comment.PHP_EOL);
fclose($fp);

$lines=file($filename,FILE_SKIP_EMPTY_LINES);
echo $lines[0];
echo $lines[1];
echo $lines[2];
?>
