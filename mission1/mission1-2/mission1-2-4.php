<?php
$hensu="PHP daisuki";
$filename="mission1-2.txt";
$fp=fopen($filename,"w");
fwrite($fp,$hensu);
fclose($fp);
 ?>
