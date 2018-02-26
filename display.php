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

     // 一覧表示用の配列を用意
     $post_big = array();
     $post_middle = array();
     $post_small = array();
     $display_list = array();
     $row_big = array();
     $row_middle = array();
     $row_small = array();
     $size_big = array();
     $size_middle = array();
     $size_sm = array();
     $size_small = array();
     $favorite_list= array();

     $type = 'B';
     $empty_big = 0;
     $empty_middle = 0;
     $empty_small = 0;
     $b = 1;
     $m = 1;
     $sm = 1;
     $s = 0;   
     $n = 1;


     // 複数行のデータを取得するためループ
    while (1) {
      $one_post = $stmt->fetch(PDO::FETCH_ASSOC);
      // var_dump($one_post);
      // exit;
      if($one_post == false){
      break;
     }else{
      // like数を求めるSQL文
      $like_sql = "SELECT COUNT(*)as `like_count` FROM `kotobato_likes` WHERE `post_id`=".$one_post["id"];
      // SQL文実行
      $like_stmt = $dbh->prepare($like_sql);
      $like_stmt->execute();
      $like_number = $like_stmt->fetch(PDO::FETCH_ASSOC);
      //1行分のデータに新しいキーを用意して、like数を代入
      $one_post["like_count"] = $like_number["like_count"];
      // ログインしている人がLikeしているかどうかの情報を取得
      $login_like_sql = "SELECT COUNT(*) as `like_count` FROM `kotobato_likes` WHERE `post_id`=".$one_post['id']." AND `member_id` =".$_SESSION["id"];
      // SQL文実行
      $login_like_stmt = $dbh->prepare($login_like_sql);
      $login_like_stmt->execute();

      // フェッチして取得
      $login_like_number = $login_like_stmt->fetch(PDO::FETCH_ASSOC);
      $one_post["login_like_flag"] = $login_like_number["like_count"];



      // like数を求めるSQL文
      $favorite_sql = "SELECT COUNT(*)as `favorite_count` FROM `kotobato_favorites` WHERE `post_id`=".$one_post["id"];
      // SQL文実行
      $favorite_stmt = $dbh->prepare($favorite_sql);
      $favorite_stmt->execute();
      $favorite_number = $favorite_stmt->fetch(PDO::FETCH_ASSOC);
      //1行分のデータに新しいキーを用意して、like数を代入
      $favorite_post["favorite_count"] = $favorite_number["favorite_count"];
      // ログインしている人がLikeしているかどうかの情報を取得
      $login_favorite_sql = "SELECT COUNT(*) as `favorite_count` FROM `kotobato_favorites` WHERE `post_id`=".$one_post['id']." AND `member_id` =".$_SESSION["id"];
      // SQL文実行
      $login_favorite_stmt = $dbh->prepare($login_favorite_sql);
      $login_favorite_stmt->execute();

      // フェッチして取得
      $login_favorite_number = $login_favorite_stmt->fetch(PDO::FETCH_ASSOC);
      $one_post["login_favorite_flag"] = $login_favorite_number["favorite_count"];


        if($one_post["like_count"] >= 10){
          $row_big["row"] = $b*3 - 2;
          $size_big["size"] = "B";
          $post_big[] = array_merge($row_big,$one_post,$size_big);
          $b++;         

        }elseif (10 > $one_post["like_count"] && $one_post["like_count"] > 1) {
          $row_middle["row"] = $m*3 - 1;
          $size_middle["size"] = "M";
          $post_middle[] = array_merge($row_middle,$one_post,$size_middle);
          $m++;

        }else{
          if(($n+3)%4 == 0){
          $row_small["row"] = $sm*3 -1;
          $size_sm["size"] = "SM";
          $post_small[] = array_merge($row_small,$one_post,$size_sm);          
          $sm++;
          $s++;
          }
          if(($n+3)%4 == 1 || ($n+3)%4 == 2 || ($n+3)%4 == 3){
          $row_small["row"] = $s*3;
          $size_small["size"] = "S";
          $post_small[] = array_merge($row_small,$one_post,$size_small);
          }
        $n++;
        }
      }

    }
  }catch(Exception $e){
    exit();
  }


  try{
            //       echo "<pre>";
            // var_dump($display_list);
            // echo "</pre>";
            // exit;

        while (1) {
          if($empty_big == 1 && $empty_middle == 1 && $empty_small == 1){
            break;

          }else{

            if ($type == 'B') {
              if (!empty($post_big)) {

                $display_list[] = $post_big[0];
                unset($post_big[0]);
                $post_big = array_values($post_big);
                $type = 'M';
            // var_dump($$display_list);
            // exit;
                  
              }
              if(empty($post_big)){

                $type = 'M';
                $empty_big = 1;                
            // var_dump($$display_list);
            // exit;
              }   
            }
            
            if ($type == 'M') {
              if (!empty($post_middle)) {

              $display_list[] = $post_middle[0];
              unset($post_middle[0]);
              $post_middle = array_values($post_middle);
              $type = 'S';

              }
              if(empty($post_middle)){

                $type = 'S';
                $empty_middle = 1;

              }
            }

            if($type == 'S'){
              if (!empty($post_small[0])) {

              $display_list[] = $post_small[0];
              unset($post_small[0]);

                if (!empty($post_small[1])) {
                $display_list[] = $post_small[1];
                unset($post_small[1]);

                  if (!empty($post_small[2])) {
                  $display_list[] = $post_small[2];
                  unset($post_small[2]);

                    if (!empty($post_small[3])) {
                    $display_list[] = $post_small[3];
                    unset($post_small[3]);
                    }
                  }
                }

              $type = 'B'; 
              $post_small = array_values($post_small);

              }

            }
            if(empty($post_small[0])){
              $type = 'B';
              $empty_small = 1;
            }     

          }

        }

            // echo "<pre>";
            // var_dump($display_list);
            // echo "</pre>";
            // exit;

  }catch(Exception $e){

    exit();
  }


  try{
    // echo "<pre>";
    //  var_dump($display_list);
    // echo "</pre>";
    //   exit;
     // var_dump($one_post);
    
    // followingの数
    $following_sql ="SELECT COUNT(*) as `cnt` FROM `kotobato_follows` WHERE `member_id` =".$_SESSION["id"];
    $following_stmt = $dbh->prepare($following_sql);
    $following_stmt->execute();
    $following = $following_stmt->fetch(PDO::FETCH_ASSOC);

    // Followerの数
    $follower_sql ="SELECT COUNT(*) as `cnt` FROM `kotobato_follows` WHERE `follower_id` =".$_SESSION["id"];
    $follower_stmt = $dbh->prepare($follower_sql);
    $follower_stmt->execute();
    $follower = $follower_stmt->fetch(PDO::FETCH_ASSOC);


    }catch(Exception $e){
    echo 'SQL実行エラー:'.$e->getMessage();
    exit();
  }

 ?>

<?php
  try{ 
    $sql_fo = "SELECT * FROM `kotobato_follows` WHERE `member_id`=".$_SESSION["id"];
    $stmt_fo = $dbh->prepare($sql_fo);
    $stmt_fo->execute();

    $follows = array();

    while (1) {
    $follow_one = $stmt_fo->fetch(PDO::FETCH_ASSOC);
      if($follow_one == false){
        break;
      }else{

        $follows[] = $follow_one;
      }
    }
  }catch(Exception $e){
    echo 'SQL実行エラー:'.$e->getMessage();
    exit();
  }



            // echo "<pre>";
            // var_dump($_SESSION);
            // echo "</pre>";
            // exit;
    $display = array();
    foreach ($display_list as $one) {
      foreach ($follows as $f) {


          if ($one["member_id"] == $f["follower_id"]){
             
             $display[]=$one;
          }
        
      }
    }

            // echo "<pre>";
            // var_dump($display);
            // echo "</pre>";
            // exit;

 ?>


<?php 
// メモ書き

  // try {

  //   // $sql_display = "SELECT `kotobato_posts`.*,`kotobato_likes`.`post_id`,count(*) AS COUNT FROM `kotobato_posts` INNER JOIN `kotobato_likes` ON `kotobato_posts`.`id`=`kotobato_likes`.`post_id` WHERE `kotobato_posts`.`modified` GROUP BY ORDER BY COUNT DESC";


  //   $sql_display = "SELECT `kotobato_posts`.*,`kotobato_likes`.`member_id`,`kotobato_likes`.`post_id`,`kotobato_members`.* FROM `kotobato_posts` INNER JOIN (`kotobato_likes` INNER JOIN `kotobato_posts` ON `kotobato_posts`.`id`=`kotobato_likes`.`post_id`) ON `kotobato_members`.`id`= `kotobato_posts`.`member_id` WHERE `kotobato_posts`.`modified` GROUP BY ORDER BY COUNT DESC";

  //       // $sql_display = "SELECT `kotobato_posts`.*,`kotobato_likes`.`post_id`,count(post_id) AS COUNT FROM `kotobato_posts` INNER JOIN `kotobato_likes` ON `kotobato_posts`.`id`=`kotobato_likes`.`post_id` WHERE `kotobato_posts`.`modified` BETWEEN".$date_old."AND".$date_now."GROUP BY ORDER BY COUNT DESC";

  //   $stmt_display = $dbh->prepare($sql_display);
  //   $stmt_display->execute();

  //   while (1) {
  //   $one_display = $stmt_display->fetch(PDO::FETCH_ASSOC);
  //          // var_dump($one_display);
  //          // exit;
  //   }if($one_display == false){
  //   break;
  //   }else{
  //   if($one_display["count"] > 10){
  //     // 投稿表示大
  //     $post_big = $one_display;

  //     }elseif (10 > $one_display["count"] && $one_display["count"] > 4){
  //     //投稿表示中
  //     $post_middle = $one_display;

  //     }else{
  //     // 投稿表示小
  //     $post_middle = $one_display;
  //     }

  //   }

     
  //   $i = 0;
  //   $date_now = date('Y-m-d H:i:s');
  //   $date_old = date('Y-m-d H:i:s', strtotime("-$n days"));

  //   // $date_now = 10000 + date(md);
  //   if (!empty($post_big)){
  //     for ($i=1; $i < 480; $i++) { 
  //      $n = 7 * $i;

  //      $n
  //     }  
      
  //   } 

  // }catch (Exception $e) {
  //   echo 'SQL実行エラー:'.$e->getMessage();
  //   exit();
    
  // }


        // while (1) {
        //   if(!empty($post_big[0]) && ($type = 'B')){
        //     $$display_list["B"] = $post_big[0];
        //     unset($post_big[0]);
        //     $type = 'M';
        //     // var_dump($$display_list);
        //     // exit;
        //   }elseif(empty($post_big[0]) && ($type = 'B')){
        //     $type = 'M';
        //     $empty_big = 1;
        //   }  

        //   if(!empty($post_middle[0]) && ($type = 'M')){
        //     $$display_list["M"] = $post_middle[0];
        //     unset($post_middle[0]);
        //     $type = 'S';
        //   }elseif(empty($post_middle[0]) && ($type = 'M')){
        //     $type = 'S';
        //     $empty_middle = 1;
        //   }

        //   if(!empty($post_small[0]) && ($type = 'S')){
        //     $$display_list["S"] = $post_small[0];
        //     unset($post_small[0]);
        //     $type = 'B';
        //   }elseif(empty($post_small[0]) && ($type = 'S')){
        //     $type = 'B';
        //     $empty_small = 1;
        //   }
        //   if(($empty_big = 1) && ($empty_middle = 1) && ($empty_small = 1)){
        //   break;
        //   }
        
        // }
// while (1) {
//           if($empty_big == 1 && $empty_middle == 1 && $empty_small == 1){
//             break;
//           }elseif(!empty($post_big) && ($type == 'B')){
//             $$display_list["B"] = $post_big[0];
//             unset($post_big[0]);
//             $post_big = array_values($post_big);
//             $type = 'M';
//             // var_dump($post_big);
//             // exit;
//           }elseif(empty($post_big) && ($type == 'B')){
//             $type = 'M';
//             $empty_big = 1;
//             // var_dump($post_big);
//             // exit;
//           }elseif(!empty($post_middle) && ($type == 'M')){
//             $$display_list["M"] = $post_middle[0];
//             unset($post_middle[0]);
//             $post_middle = array_values($post_middle);
//             $type = 'S';
//             // var_dump($post_middle);
//             // exit;
//           }elseif(empty($post_middle) && ($type == 'M')){
//             $type = 'S';
//             $empty_middle = 1;
//             //  var_dump($post_big);
//             // exit;
//           }elseif(!empty($post_small) && ($type == 'S')){

//             $$display_list["MS"] = $post_small[0];
//             unset($post_small[0]);

//               if(!empty($post_small[1])){
//                 $$display_list["S"] = $post_small[1];
//                 unset($post_small[1]);
//               }elseif(!empty($post_small[2])) {
//                 $display_list["S"] = $post_small[2];
//                 unset($post_small[2]);
//               }elseif (!empty($post_small[3])) {
//                 $display_list["S"] = $post_small[3];
//                 unset($post_small[3]);
//               }             

//             $post_small = array_values($post_small);

//             $type = 'B';

//           }elseif(empty($post_small) && ($type == 'S')){
//             $type = 'B';
//             $empty_small = 1;

//           }
//         }


          // (!empty($post_big) && ($type == 'B')){
          //   $display_list["B"] = $post_big[0];
          //   unset($post_big[0]);
          //   $post_big = array_values($post_big);
          //   $type = 'M';
          //   // var_dump($post_big);
          //   // exit;
          // }elseif(empty($post_big) && ($type == 'B')){
          //   $type = 'M';
          //   $empty_big = 1;
          //   // var_dump($post_big);
          //   // exit;
          // }elseif(!empty($post_middle) && ($type == 'M')){
          //   $display_list["M"] = $post_middle[0];
          //   unset($post_middle[0]);
          //   $post_middle = array_values($post_middle);
          //   $type = 'S';
          //   // var_dump($post_middle);
          //   // exit;
          // }elseif(empty($post_middle) && ($type == 'M')){
          //   $type = 'S';
          //   $empty_middle = 1;
          //   //  var_dump($post_big);
          //   // exit;
          // }elseif(!empty($post_small) && ($type == 'S')){

          //   $display_list["MS"] = $post_small[0];
          //   unset($post_small[0]);

          //     if(!empty($post_small[1])){
          //       $display_list["S"] = $post_small[1];
          //       unset($post_small[1]);
          //     }elseif(!empty($post_small[2])) {
          //       $display_list["S"] = $post_small[2];
          //       unset($post_small[2]);
          //     }elseif (!empty($post_small[3])) {
          //       $display_list["S"] = $post_small[3];
          //       unset($post_small[3]);
          //     }             

          //   $post_small = array_values($post_small);

          //   $type = 'B';

          // }elseif(empty($post_small) && ($type == 'S')){
          //   $type = 'B';
          //   $empty_small = 1;

          // }

        

 ?>