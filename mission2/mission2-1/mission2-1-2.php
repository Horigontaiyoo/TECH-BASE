<?php
//・GET⇒データがURLで引き渡される
//・POST⇒データがURLで引き渡されない
$comment=$_POST['comment'];

if(!empty($comment)&&$comment=="finish"){
  echo "おめでとう！";
}elseif(!empty($comment)){
  echo $comment."を受け付けました";}


$filename="mission2-2-1.txt";
$fp=fopen($filename,"w");
fwrite($fp,$comment);
fclose($fp);
?>
