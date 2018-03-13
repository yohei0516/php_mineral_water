<?php 

  session_start();

  //DBの接続
  require('dbconnect.php');


// likeボタンが押されたとき
  if(isset($_GET["favorite_post_id"])){
    // like関数を引っ張ってきている
    favorite($_GET["favorite_post_id"],$_SESSION["id"]);

  }

  if(isset($_GET["unfavorite_post_id"])){
    unfavorite($_GET["unfavorite_post_id"],$_SESSION["id"]);

  }

            // echo "<pre>";
            // var_dump($_GET);
            // echo "</pre>";
            // exit;

  function favorite($favorite_post_id,$login_member_id){
    // 関数の中に書く
     require('dbconnect.php');
         // like情報をlikeテーブルに登録
    $sql = "INSERT INTO `kotobato_favorites` (`post_id`,`member_id`) VALUES (".$favorite_post_id.",".$login_member_id.");";
    // SQL実行
     $stmt = $dbh->prepare($sql);
     $stmt->execute();
          // 一覧ページへもどる
     header("Location: favorite.php?member_id=".$_GET["member_id"]);
  }

  function unfavorite($unfavorite_post_id,$login_member_id){
    require('dbconnect.php');
        // 登録されているlike情報をumlikeテーブルから削除
    $sql = 'DELETE FROM `kotobato_favorites` WHERE post_id='.$unfavorite_post_id.' AND member_id='.$login_member_id;
    // SQL実行
     $stmt = $dbh->prepare($sql);
     $stmt->execute();
     header("Location: favorite.php?member_id=".$_GET["member_id"]);
  }

 ?>