<?php 

  session_start();

  //DBの接続
  require('dbconnect.php');


// likeボタンが押されたとき
  if(isset($_GET["like_post_id"])){
    // like関数を引っ張ってきている
    like($_GET["like_post_id"],$_SESSION["id"]);


    // // like情報をlikeテーブルに登録
    // $sql = "INSERT INTO `likes` (`tweet_id`, `member_id`) VALUES (".$_GET["like_tweet_id"].", ".$_SESSION["id"].");";

    // // SQL実行
    //  $stmt = $dbh->prepare($sql);
    //  $stmt->execute();

    //       // 一覧ページへもどる
    //  header("Location: index.php");

  }


// umlikeボタンが押されたとき
  if(isset($_GET["unlike_post_id"])){
    unlike($_GET["unlike_post_id"],$_SESSION["id"]);

    // 登録されているlike情報をumlikeテーブルから削除
    // $sql = 'DELETE FROM `likes` WHERE tweet_id='.$_GET["unlike_tweet_id"].' AND member_id='.$_SESSION["id"];

    // // SQL実行
    //  $stmt = $dbh->prepare($sql);
    //  $stmt->execute();



    //  // 一覧ページへもどる
    //  header("Location: index.php");

  }


  //like関数
  //引数 like_tweet_id,login_member_id
  function like($like_post_id,$login_member_id){
    // 関数の中に書く
     require('dbconnect.php');
         // like情報をlikeテーブルに登録
    $sql = "INSERT INTO `kotobato_likes` (`post_id`,`member_id`) VALUES (".$like_post_id.", ".$login_member_id.");";

    // SQL実行
     $stmt = $dbh->prepare($sql);
     $stmt->execute();
     
          // 一覧ページへもどる
     header("Location: profile.php?member_id=".$_GET["member_id"]);

  }

 //引数 like_tweet_id,login_member_id
  function unlike($unlike_post_id,$login_member_id){

    require('dbconnect.php');
        // 登録されているlike情報をumlikeテーブルから削除
    $sql = 'DELETE FROM `kotobato_likes` WHERE post_id='.$unlike_post_id.' AND member_id='.$login_member_id;

    // SQL実行
     $stmt = $dbh->prepare($sql);
     $stmt->execute();
     header("Location: profile.php?member_id=".$_GET["member_id"]);

  }

 ?>