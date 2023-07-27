<?php
//1. POSTデータ取得
//$name = filter_input( INPUT_GET, ","name" ); //こういうのもあるよ
//$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ
$bookname = $_POST['bookname'];
$url = $_POST['url'];
$comment = $_POST['comment'];
//↑前回授業の復習

//2. DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=aya-17-ms_gs_bm;charset=utf8;host=mysql57.aya-17-ms.sakura.ne.jp','aya-17-ms','0000000-');
} catch (PDOException $e) {
  exit('DBConnection Error:'.$e->getMessage());
}


//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_bm_table(bookname,url,comment,indate)VALUES(:bookname, :url, :comment, sysdate());");
$stmt->bindValue(':bookname', $bookname, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':url', $url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("***********:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: index.php");
  exit();
}
?>
