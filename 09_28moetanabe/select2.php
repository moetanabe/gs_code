<?php
session_start();

//1.  DB接続します
include "funcs.php";
chk_Ssid();
$pdo = db_con();


//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status == false) {
  sqlError($stmt);
} else {
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
    $view .= '<p>';
    $view .= '<a href ="delete.php?id='.$result["id"].'">';
    $view .= '[×]';
    $view .= '</a>';
    
    $view .= '<a href ="detail2.php?id='.$result["id"].'">';
    $view .= $result["title"] . "," . $result["url"] . "," . $result["cmt"] . "<br>";
    $view .= '</a>';
    $view .= '</p>';
 
  }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>本のブックマーク表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">

      <?php if($_SESSION["kanri_flg"]=="1"){ ?>
      <a class="navbar-brand" href="index2.php">データ登録</a>
        
      <?php } ?>
        <a class="navbar-brand" href="logout.php">ログアウト</a>
        <?= $_SESSION["name"]?>さん、こんにちは
      
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><?=$view?></div>
</div>
<!-- Main[End] -->

</body>
</html>
