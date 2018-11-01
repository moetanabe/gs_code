<?php
//1. POSTデータ取得
//$name = filter_input( INPUT_GET, ","name" ); //こういうのもあるよ
//$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ

$title =$_POST["title"];
$url =$_POST["url"];
$cmt =$_POST["cmt"];


//2. DB接続します
include "funcs.php";
$pdo = db_con();


//３．データ登録SQL作成
$sql = "INSERT INTO gs_bm_table(title,url,cmt,datetime)VALUES
(:title,:url,:cmt,sysdate())"; 
$stmt =$pdo->prepare($sql);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':url', $url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':cmt', $cmt, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  sqlError($stmt);
}else{
  //５．index.phpへリダイレクト
 header("Location: index2.php");
exit;
}

?>
