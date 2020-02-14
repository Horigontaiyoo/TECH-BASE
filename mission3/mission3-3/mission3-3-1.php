<?php

$date=date("Y/m/d h時i分");
$filename="mission3-3-1.txt";
if(!empty(trim($_POST["name"]," 　"))&& !empty(trim($_POST["comment"],"　 "))){
//
  //echo "入力しました";
  $name=($_POST["name"]);
  $comment=$_POST["comment"];
  if(file_exists($filename)){
    $lines=file($filename,FILE_SKIP_EMPTY_LINES);
    $lastline= count($lines);
    $postnumber=$lastline+1;
  }else{
   $postnumber = 1;
  }

//テキストファイルに書き込む処理
  $fp=fopen($filename,"a");
  fwrite($fp,$postnumber."<>");
  fwrite($fp,$name."<>");
  fwrite($fp,$comment."<>");
  fwrite($fp,$date.PHP_EOL);
  fclose($fp);

  echo $date."に".$name."の".$comment."を受け付けました<br><br>";

} elseif (!empty($_POST["delete"]) && empty($name) && empty($comment)) {
  $delete=$_POST["delete"];
  $lines=file($filename,FILE_SKIP_EMPTY_LINES);
  $lastline= count($lines);
  $fp=fopen($filename,"w");
  //繰り返し処理
    foreach($lines as $line){
    $word=explode("<>",$line);
    if($word[0] !=$delete){
      fwrite($fp,$line);
    }else{
      fwrite($fp,$delete."<><>消去しました。<>".PHP_EOL);
    }
  }

  fclose($fp);
  echo $delete."を削除しました<br>";
}else{
  echo "入力されていません。";
}

$lines=file($filename,FILE_SKIP_EMPTY_LINES);
//phpの処理は絶対してほしいから、分岐の外に出す。（投稿であれ、削除であれ）
foreach ($lines as $line) {
  $word=explode("<>",$line);
  echo $word[0].":".$word[1]."[".$word[3]."]<br>";
  echo "⇒".$word[2];
  echo "<br>";
}
