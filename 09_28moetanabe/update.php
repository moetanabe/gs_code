<?php
//1. POSTデータ取得
$title = $_POST["title"];
$url = $_POST["url"];
$cmt = $_POST["cmt"];
$id = $_POST["id"];

//2. DB接続します
include "funcs.php";
$pdo = db_con();

//３．データ登録SQL作成

$sql = "UPDATE gs_bm_table SET title=:title,url =:url,cmt=:cmt WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':title', $name, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':url', $email, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':cmt', $cmt, PDO::PARAM_INT); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

$status = $stmt->execute();

//４．データ登録処理後
if ($status == false) {
    sqlError($stmt);
} else {
    //５．index.phpへリダイレクト
    header("Location: select2.php");
    exit;
}
