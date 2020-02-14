<html>

<head>

 <meta charset="utf-8">

</head>

<body>

  <form action="./mission3-4-1.php" method="post">

  <span style="font-size: 12px;">＜名前＞:</span>
  <input type="text" name="name"><br>

  <span style="font-size: 12px;">＜コメント＞:</span>
  <input name="comment" ></input>

  <input type="submit" name="button" value="送信" style="font-size: 12px;"><br>

  <span style="font-size: 12px;">＜削除番号＞:</span>
  <input type="number" name="delete" style="width:40px;">

  <input type="submit"  name="button" value="削除" style="font-size: 12px;">

  <span style="font-size: 12px;">＜編集番号＞:</span>
  <input type="number" name="edit" style="width:40px;">

  <input type="submit" name="button" value="編集" style="font-size: 12px;"><br>

  <?php if(!empty($_POST["edit"])&& empty(trim($_POST["delete"],"　 "))&& empty(trim($_POST["name"]," 　"))&& empty(trim($_POST["comment"]," 　"))){
  }else{
    echo "</form>";
  }
   ?>

  <?php
  $filename="mission3-4-1.txt";
  //もし入力欄が空でなければ進んでいいよ。
if(!empty($_POST{"button"})){
  $date=date("Y/m/d h時i分");
  if(!empty(trim($_POST["name"],"　 "))&& !empty(trim($_POST["comment"],"　 "))&& empty($_POST["delete"])&& empty($_POST["edit"])&& empty($_POST["edit_number"])){
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

    //echo $date."に".$name."の".$comment."を受け付けました<br><br>";

  } elseif (!empty($_POST["delete"]) && empty(trim($_POST["name"]," 　")) && empty(trim($_POST["comment"]," 　"))) {
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
    //編集の数字のみ書き込まれている場合の処理。
    //本来であればinput numberを使うところは、trim関数は必要ない。
  } elseif(!empty($_POST["edit"])&& empty(trim($_POST["delete"],"　 "))&& empty(trim($_POST["name"]," 　"))&& empty(trim($_POST["comment"]," 　"))){
  $date=date("Y/m/d h時i分");
  $edit=$_POST["edit"];
  $lines=file($filename,FILE_SKIP_EMPTY_LINES);
  $lastline= count($lines);
  //echo $edit;デバック。POST送信の確認。
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
    }
  }
  //編集番号が入力された時のみフォーム表示。
  //echoはhtmlに出力するという処理。フォームごと出力する。
  //外をシングルクォーテーションで囲うのはダブルと差別化するため。
  //変数出力時は、ダブルで囲わないと文字列として認識されない。
  echo
  '<span style="font-size: 12px;">＜名前＞:</span>
  <input type="text" name="edit_name" value="'.$edit_name.'"></input><br>
  <span style="font-size: 12px;">＜コメント＞:</span>
  <input type="text" name="edit_comment" value="'.$edit_comment.'"></input>
  <input type="hidden" name="edit_number" value="'.$edit_number.'"></input>
  <input type="submit" name="button" value="編集する" style="font-size: 12px;"><br>
  </form>';
}else{
  echo "編集番号が間違っています。";
}
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
      fwrite($fp,$edit_number."<>".$edit_name."<>".$edit_comment."<>".$date.PHP_EOL);
    }
  }fclose($fp);
  }else{
  //今度はテキストファイルを書き換えたい
  echo "入力されていません。<br>";
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
  ?>
</body>

</html>
