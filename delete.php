<?php
  require("function.php");

  //ログインチェック
  login_check();

   //DBの接続
require('dbconnect.php');

//削除したいtweet_id
$delete_post_id = $_GET['id'];

//論理削除用のUPDATE文
$sql = "UPDATE `kotobato_posts` SET `delete_flag` = '1' WHERE `kotobato_posts`.`id` = ".$delete_post_id;

//SQL実行
$stmt = $dbh->prepare($sql);
$stmt->execute();

//一覧画面にもどる
header("Location: main.php");
exit();


?>