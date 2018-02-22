<?php 

//----- ページング処理
$page = "";
//パラメータが存在していたらページ番号代入
if(isset($_GET["page"])){

  $page = $_GET["page"];
}else{
//存在しないときはページ１とする
  $page = 1;
}

//１以下のページ番号を入力されたら数字を１にする
//カンマ区切りで羅列された数字の中で最大の数字
$page = max($page,1);

//1ページ分の表示件数
$page_row = 100;

//データの件数から最大ページ数を計算する
//AS `cnt`を使うとfetchしたデータから取り出したCOUNT(*)データが
$sql = "SELECT COUNT(*)  AS `cnt` FROM `kotobato_posts` WHERE `delete_flag`=0";
$page_stmt = $dbh->prepare($sql);
$page_stmt->execute();

$record_count = $page_stmt->fetch(PDO::FETCH_ASSOC);

// var_dump($record_count);
// exit;
// 小数点の繰り上げ
$all_page_number = ceil($record_count['cnt'] / $page_row);

//パラメータのページ番号が最大ページを超えていれば、強制的に最後のページとする。
//min カンマ区切りの数字の羅列の中から最小の数字を取得する。
$page = min($page,$all_page_number);

//$startは表示するデータの表示開始場所
  $start = ($page-1) * $page_row;
// var_dump($all_page_number);

 ?>
 <?php 


// //----- ページング処理
// $page = "";
// //パラメータが存在していたらページ番号代入
// if(isset($_GET["page"])){

//   $page = $_GET["page"];
// }else{
// //存在しないときはページ１とする
//   $page = 1;
// }

// //１以下のページ番号を入力されたら数字を１にする
// //カンマ区切りで羅列された数字の中で最大の数字
// $page = max($page,1);

// //1ページ分の表示件数
// $page_row = 100;

// //データの件数から最大ページ数を計算する
// //AS `cnt`を使うとfetchしたデータから取り出したCOUNT(*)データが
// $sql = "SELECT COUNT(*)  AS `cnt` FROM `kotobato_posts` WHERE `delete_flag`=0";
// $page_stmt = $dbh->prepare($sql);
// $page_stmt->execute();

// $record_count = $page_stmt->fetch(PDO::FETCH_ASSOC);

// // var_dump($record_count);
// // exit;
// // 小数点の繰り上げ
// $all_page_number = ceil($record_count['cnt'] / $page_row);

// //パラメータのページ番号が最大ページを超えていれば、強制的に最後のページとする。
// //min カンマ区切りの数字の羅列の中から最小の数字を取得する。
// $page = min($page,$all_page_number);

// //$startは表示するデータの表示開始場所
//   $start = ($page-1) * $page_row;
// // var_dump($all_page_number);
  ?>