<html>

<head>

 <meta charset="utf-8">

</head>

<body>

  <form action="./mission3-5.php" method="post">

  <span style="font-size: 12px;">＜名前＞:</span>
  <input type="text" name="name"><br>

  <span style="font-size: 12px;">＜コメント＞:</span>
  <input type="text" name="comment" ></input><br>


  <span style="font-size: 12px;">＜パスワード＞:</span>
  <input type="text" name="pass" style="width:80px;">
  <input type="submit" name="button" value="送信" style="font-size: 12px;"><br>

  <span style="font-size: 12px;">(削除番号:</span>
  <input type="number" name="delete" style="width:40px;">

  <input type="submit"  name="button" value="削除" style="font-size: 12px;">

  <span style="font-size: 12px;">編集番号:</span>
  <input type="number" name="edit" style="width:40px;">

  <input type="submit" name="button" value="編集" style="font-size: 12px;">

  <span style="font-size: 12px;">パスワード(確認用):</span>
  <input type="text" name="check_pass" style="width:80px;">)<br>

<!--編集の欄に中身がある場合のみ</form>を表示しない-->
  <?php

  $dsn='mysql:dbname=tb210834db;host=localhost;';
  $user='tb-210834';
  $password='PzGgWnPAyS';
  $pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
//.txtに書き込んでいた内容を書くためにデーターベース上に表を作る作業
  $sql="CREATE TABLE IF NOT EXISTS keiziban"
  ." ("
  ."number INT AUTO_INCREMENT PRIMARY KEY,"
  //char 半角で1文字判定してくれる。TEXTは無限に書き込める。
  ."name char(32),"
  ."comment TEXT"
  ."date TEXT"
  ."password TEXT"
  .");";
  //queryは実行するという意味
  $stmt=$pdo->query($sql);

  if(!empty($_POST["edit"])&& empty(trim($_POST["delete"],"　 "))&& empty(trim($_POST["name"]," 　"))&& empty(trim($_POST["comment"]," 　"))&& empty(trim($_POST["pass"]," 　"))&&!empty(trim($_POST["check_pass"]," 　"))){

  }else{
    echo "</form>";
  }
   ?>

  <?php
  $filename="mission3-5.txt";
  //もし入力欄が空でなければ進んでいいよ。
if(!empty($_POST{"button"})){
  $date=date("Y/m/d h時i分");
  if(!empty(trim($_POST["name"],"　 "))&& !empty(trim($_POST["comment"],"　 "))&& !empty(trim($_POST["pass"]," 　"))&& empty(trim($_POST["check_pass"]," 　")) &&empty($_POST["delete"])&& empty($_POST["edit"])&&
   empty($_POST["edit_number"])){
     //新規編集フォームにhiddenで隠れた数字が入っている場合、このifは通らない。
  //
    //echo "[debug]入力しました";
    $name=($_POST["name"]);
    $comment=$_POST["comment"];
    $pass=$_POST["pass"];
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
    fwrite($fp,$date."<>");
    fwrite($fp,$pass."<>".PHP_EOL);
    fclose($fp);

    //echo $date."に".$name."の".$comment."を受け付けました<br><br>";

  } elseif (!empty($_POST["delete"]) && empty(trim($_POST["name"]," 　")) && empty(trim($_POST["comment"]," 　"))&& empty(trim($_POST["pass"]," 　"))&& !empty(trim($_POST["check_pass"]," 　"))&& empty($_POST["edit"])) {
    $delete=$_POST["delete"];
    $in_pass=$_POST["check_pass"];
    $lines=file($filename,FILE_SKIP_EMPTY_LINES);
    $lastline= count($lines);
    //繰り返し処理
    //フラグ
    $ok=false;
    foreach($lines as $line){
      $word=explode("<>",$line);
      //echo "[debug]".$word[4].$in_pass."<br>";
    if($word[4]==$in_pass&&$word[0]==$delete){
      $ok=true;
    }else{
    //  echo "パスワードが違います";
    }
  }

  if(!$ok){
      echo "passwordが違います";
    }

  if($ok){
      $fp=fopen($filename,"w");
      foreach($lines as $line){
      $word=explode("<>",$line);
      if($word[0] !=$delete){
        fwrite($fp,$line);
      }else{
        $date=date("Y/m/d h時i分");
        fwrite($fp,$delete."<><>消去しました。<>".$date."<><>".PHP_EOL);
      }
    }

    fclose($fp);
    echo $delete."を削除しました<br>";
    //編集の数字のみ書き込まれている場合の処理。
    //本来input numberを使うところは、trim関数は必要ない。
  }
  } elseif(!empty($_POST["edit"])&& empty(trim($_POST["delete"],"　 "))&& empty(trim($_POST["name"]," 　"))&& empty(trim($_POST["comment"]," 　"))&& empty(trim($_POST["pass"]," 　"))&& !empty(trim($_POST["check_pass"]," 　"))){
  $date=date("Y/m/d h時i分");
  $edit=$_POST["edit"];
  $in_pass=$_POST["check_pass"];
  $lines=file($filename,FILE_SKIP_EMPTY_LINES);
  $lastline= count($lines);
  //echo $edit;デバック。POST送信の確認。
  $ok=0;
  foreach($lines as $line){
    $word=explode("<>",$line);
    //echo "[debug]".$word[4].$in_pass."<br>";
  if($word[4]==$in_pass&&$word[0]==$edit){
    $ok=1;
  }else{
  //  echo "パスワードが違います";
  }
  }

  if($ok==0){
    echo "passwordが違います";
  }
  if($ok==1){
  if($edit<=$lastline&&$edit>0){
  //繰り返し処理
  foreach($lines as $line){
    $word=explode("<>",$line);
    //echo $word[0];
    if($word[0] == $edit){
      $edit_name=$word[1];
      $edit_comment=$word[2];
      $edit_number=$word[0];
      //echo "[デバック] edit_name=".$edit_name."edit_comment".$edit_comment."edit_number".$edit_number;
      echo
      '<span style="font-size: 12px;">＜名前＞:</span>
      <input type="text" name="edit_name" value="'.$edit_name.'"></input><br>
      <span style="font-size: 12px;">＜コメント＞:</span>
      <input type="text" name="edit_comment" value="'.$edit_comment.'"></input>
      <input type="hidden" name="edit_number" value="'.$edit_number.'"></input>
      <input type="submit" name="button" value="編集する" style="font-size: 12px;"><br>
      </form>';
    }
  }
}
}
  //編集番号が入力された時のみフォーム表示。
  //echoはhtmlに出力するという処理。フォームごと出力する。
  //外をシングルクォーテーションで囲うのはダブルと差別化するため。
  //変数出力時は、ダブルで囲わないと文字列として認識されない。

}elseif(!empty($_POST["edit_name"])&&!empty($_POST["edit_comment"])&&!empty($_POST["edit_number"])//&& empty($_POST["delete"])
){
  $edit_name=$_POST["edit_name"];
  $edit_comment=$_POST["edit_comment"];
  $edit_number=$_POST["edit_number"];
    //echo "[デバック] edit_name=".$_POST["edit_name"]."edit_comment".$edit_comment."edit_number".$edit_number;
  $lines=file($filename,FILE_SKIP_EMPTY_LINES);
  $lastline= count($lines);
  $fp=fopen($filename,"w");
  foreach($lines as $line){
    $word=explode("<>",$line);
    if($word[0]!=$edit_number){
      fwrite($fp,$line);
    }else{
      fwrite($fp,$edit_number."<>".$edit_name."<>".$edit_comment."<>".$date."<>".$word[4]."<>".PHP_EOL);
    }
  }fclose($fp);
}elseif(isset($_POST["edit_number"])&&(empty($_POST["edit_name"])||empty($_POST["edit_comment"])) ){
  echo "編集の際の入力欄が空です。";
}elseif (!empty(trim($_POST["comment"]," 　"))&&empty(trim($_POST["pass"]," 　"))||(!empty(trim($_POST["delete"],"　 "))||!empty($_POST["edit"]))&&empty(trim($_POST["check_pass"]," 　"))){
  echo "パスワードが入力されていません";
}else{
  //今度はテキストファイルを書き換えたい
  echo "入力条件を満たしていません。<br>";
}
}

  $lines=file($filename,FILE_SKIP_EMPTY_LINES);
  //phpの処理は絶対してほしいから、分岐の外に出す。（投稿であれ、削除であれ）
  echo "<hr>";
  foreach ($lines as $line) {
    $word=explode("<>",$line);
    echo $word[0].":".$word[1]." [".$word[3]."]<br>";
    echo "⇒".$word[2];
    echo "<br>";
    echo "<hr>";
  }
//echo tasizann(1,2);
//echo tasizann(34,44);
//echo tasizann($edit,$number);

//function a($num1,$num2){
  //$num1 = 1; $num2 = 2;
  //$answer = $num1 - $num2;
  //return $answer; }

function check_pass($origin_pass,$enter_pass){
  if($origin_pass==$enter_pass){
    return true;

}else{
    return false;
}
}
  ?>
</body>

</html>
