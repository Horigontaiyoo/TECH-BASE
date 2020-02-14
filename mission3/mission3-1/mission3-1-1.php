<?php

$name=$_POST["name"];
$comment=$_POST["comment"];
$date=date("Y/m/d h時i分");
$filename="mission3-1-1.txt";
if(!empty($name)&& !empty($comment)){
  echo $date."に".$name."の".$comment."を受け付けました";
}

if(file_exists($filename)){
  $lines=file($filename,FILE_SKIP_EMPTY_LINES);
  $lastline= count($lines);
  $postnumber=$lastline+1;
}else{
 $postnumber = 1;
}



$fp=fopen($filename,"a");
fwrite($fp,$postnumber."<>");
fwrite($fp,$name."<>");
fwrite($fp,$comment."<>");
fwrite($fp,$date.PHP_EOL);
fclose($fp);
