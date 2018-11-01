<?php
//最初にSESSIONを開始！！
session_start();

//0.外部ファイル読み込み
include("funcs.php");

//1.  DB接続します
$pdo = db_con();
$sql = "SELECT * FROM gs_user_table WHERE lid=:lid AND lpw=:lpw AND life_flg=0";
//2. データ登録SQL作成
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':lid', $_POST["lid"],PDO::PARAM_STR);
$stmt->bindValue(':lpw', $_POST["lpw"],PDO::PARAM_STR);
$res = $stmt->execute();

//3. SQL実行時にエラーがある場合
if($res==false){
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}

//4. 抽出データ数を取得
//$count = $stmt->fetchColumn(); //SELECT COUNT(*)で使用可能()
$val = $stmt->fetch(); //1レコードだけ取得する方法

//5. 該当レコードがあればSESSIONに値を代入
if( $val["id"] != "" ){
  $_SESSION["chk_ssid"]  = session_id();
  $_SESSION["kanri_flg"] = $val['kanri_flg'];
  $_SESSION["name"]      = $val['name'];
  header("Location: select2.php");
}else{
  //logout処理を経由して全画面へ
  header("Location: logout.php");
}

exit();
?>

