<?php 

  //----表示用のデータ取得-----
  try{
    // ログインしている人の情報を取得
     $sql = "SELECT * FROM `kotobato_members` WHERE `id`=".$_SESSION["id"];
     $stmt = $dbh->prepare($sql);
     $stmt->execute();
     $login_member = $stmt->fetch(PDO::FETCH_ASSOC);
     // var_dump($login_member);
     // 一覧用の情報を取得
     // テーブル結合
     // ORDER BY 最新順位並び替え
     // 論理削除に対応、delete_flag = 0のものだけ取得
     $sql = "SELECT `kotobato_posts`.*,`kotobato_members`.`nick_name` FROM `kotobato_posts` INNER JOIN `kotobato_members` ON `kotobato_posts`.`member_id`=`kotobato_members`.`id` WHERE `delete_flag`=0 ORDER BY `kotobato_posts`.`modified` DESC";

     $stmt = $dbh->prepare($sql);
     $stmt->execute();

     $favorite_list = array();

     // 複数行のデータを取得するためループ
    while (1) {
      $favorite_post = $stmt->fetch(PDO::FETCH_ASSOC);
      // var_dump($one_post);
      // exit;
      if($favorite_post == false){
      break;
     }else{
      // like数を求めるSQL文
      $favorite_sql = "SELECT COUNT(*)as `favorite_count` FROM `kotobato_favorites` WHERE `post_id`=".$favorite_post["id"];
      // SQL文実行
      $favorite_stmt = $dbh->prepare($favorite_sql);
      $favorite_stmt->execute();
      $favorite_number = $favorite_stmt->fetch(PDO::FETCH_ASSOC);
      //1行分のデータに新しいキーを用意して、like数を代入
      $favorite_post["favorite_count"] = $favorite_number["favorite_count"];
      // ログインしている人がLikeしているかどうかの情報を取得
      $login_favorite_sql = "SELECT COUNT(*) as `favorite_count` FROM `kotobato_favorites` WHERE `post_id`=".$favorite_post['id']." AND `member_id` =".$_SESSION["id"];
      // SQL文実行
      $login_favorite_stmt = $dbh->prepare($login_favorite_sql);
      $login_favorite_stmt->execute();

      // フェッチして取得
      $login_favorite_number = $login_favorite_stmt->fetch(PDO::FETCH_ASSOC);
      $favorite_post["login_favorite_flag"] = $login_favorite_number["favorite_count"];

            // echo "<pre>";
            // var_dump($favorite_post);
            // echo "</pre>";
            // exit;
      $favorite_list["login_favorite_flag"] = $favorite_post["login_favorite_flag"];

            //       echo "<pre>";
            // var_dump($favorite_list["login_favorite_flag"]);
            // echo "</pre>";
            // exit;

      }
    }


  }catch(Exception $e){
    exit();
  }


 ?>

