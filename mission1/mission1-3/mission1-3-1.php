<?php
$filename="mission1-2.txt";
$fp=fopen($filename,"r");
$content=fgets($fp);
fclose($fp);
echo $content;
?>
