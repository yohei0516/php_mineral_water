<?php 
  session_start();
  // DBの接続
  require('dbconnect.php');

 // var_dump($_GET);
 //  exit;

  // ログインしている人のプロフィール情報をmembersテーブルから取得
  $sql = "SELECT * FROM `kotobato_members` WHERE `id`=".$_GET["member_id"];
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $profile_member = $stmt->fetch(PDO::FETCH_ASSOC);
  // var_dump($profile_member);
  // exit;
  //一覧データを取得


// try{ 
//   $sql_all = "SELECT * FROM `kotobato_follows`";
//   $stmt_all = $dbh->prepare($sql_all);
//   $stmt_all->execute();


//   $follows = array();
//   $display = array();
//   $display_one = array();
//   $my_list= array();
//   $others = array();

//     while (1) {
//       $follow_all = $stmt_all->fetch(PDO::FETCH_ASSOC);


//       if($follow_all == false){
//         break;
//       }else{

//         $follows[] = $follow_all;
//       }
//     }
//   }catch(Exception $e){
//     echo 'SQL実行エラー:'.$e->getMessage();
//     exit();
// }


// try {
//   $sql_mem = "SELECT * FROM `kotobato_members`";
//   $stmt_mem = $dbh->prepare($sql_mem);
//   $stmt_mem->execute();

//   $member_all = array();

//   while(1){
//     $follow_mem = $stmt_mem->fetch(PDO::FETCH_ASSOC);
//     if($follow_mem == false){
//         break;
//       }else{
//         $member_all[] = $follow_mem;
//       }
//    }  
// }catch (Exception $e) {
//   exit;
// }


try {
  
  $sql_ing = "SELECT * FROM `kotobato_members` INNER JOIN `kotobato_follows` ON `kotobato_members`.`id` = `kotobato_follows`.`follower_id` WHERE `kotobato_follows`.`member_id` = ".$_GET["member_id"]." ORDER BY `kotobato_follows`.`created` DESC";

  $stmt_ing = $dbh->prepare($sql_ing);
  $stmt_ing->execute();
  // 一覧表示用の配列を用意
  $post_list = array();
  //　複数行のデータを取得するためループ
  while (1) {
    $one_post = $stmt_ing->fetch(PDO::FETCH_ASSOC);
    // var_dump($one_post);
    // exit;
    if ($one_post == false){
      break;
    }else{
        //following_flagを用意して、自分もフォローしていたら1,フォローしてなかったら0を代入する
        $fl_flag_sql = "SELECT COUNT(*) as `cnt` FROM `kotobato_follows` WHERE `follower_id`=".$_SESSION["id"]." AND `member_id`=".$one_post["follower_id"];
        $fl_stmt = $dbh->prepare($fl_flag_sql);
        $fl_stmt->execute();
        $fl_flag = $fl_stmt->fetch(PDO::FETCH_ASSOC);
        //一覧の時に必要
        $one_post["following_flag"]=$fl_flag["cnt"];
        //データが取得できている
      $post_list[] = $one_post;
    }
  }
}catch (Exception $e) {
  echo 'SQL実行エラー:'.$e->getMessage();
  exit();
  
}



  // echo "<pre>";
  // var_dump($post_list);
  // // exit;
  // echo "</pre>";


// foreach ($follows as $f){   
//       if($_GET["member_id"] == $f["member_id"]){
//         foreach ($member_all as $men) {
//           if($men["id"] == $f["follower_id"]){
//             $display[]= $men;
//           }
//         }
//       }
// }       



  // echo "<pre>";
  // var_dump($display);
  // exit;
  // echo "</pre>";


// foreach($follows as $o){
//   if($o["follower_id"] == $_SESSION["id"])
//     foreach($display as $j){
//       if($o["member_id"] == $j["id"]){
//         $others[] = $j;
//       }
//     }
// }


// foreach ($my_list as $p){   
//       if($_GET["member_id"] == $f["member_id"]){
//         foreach ($member_all as $men) {
//           if($men["id"] == $f["follower_id"]){
//             $display[]= $men;
//           }
//         }
//       }
// }       


//フォロー処理
// profile.php?follow_id=7 というリンクが推された＝フォローボタンが押された
  if (isset($_GET["follower_id"])){
    //follow情報を記録するSQL文を作成
    $fl_sql = "INSERT INTO `kotobato_follows` (`member_id`,`follower_id`) VALUES (?, ?);";
    $fl_data = array($_GET["follower_id"],$_SESSION["id"]);
    $fl_stmt = $dbh->prepare($fl_sql);
    $fl_stmt->execute($fl_data);
    //フォロー押す前の状態に戻す（再読込で、再度フォロー処理が動くのを防ぐ）
    header("Location: following.php?member_id=".$_GET["member_id"]);
  }

//フォロー解除処理
  if(isset($_GET["unfollow_id"])){
    // フォロー情報を削除するSQLを作成
    $sql = "DELETE FROM `kotobato_follows` WHERE `member_id`=? AND `follower_id`=?";
    $data = array($_GET["unfollow_id"],$_SESSION["id"]);
    $unfl_stmt = $dbh->prepare($sql);
    $unfl_stmt->execute($data);

    //フォロー解除を押す前の状態に戻す
    header("Location: following.php?member_id=".$_GET["member_id"]);
  }
  
 ?>

<!DOCTYPE HTML>
<!--
	Justice by gettemplates.co
	Twitter: http://twitter.com/gettemplateco
	URL: http://gettemplates.co
-->
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>コトバと</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link href="https://fonts.googleapis.com/css?family=Crimson+Text:400,400i|Roboto+Mono" rel="stylesheet">
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="css/profile/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/profile/icomoon.css">
	<!-- Simple Line Icons -->
	<link rel="stylesheet" href="css/profile/simple-line-icons.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/profile/bootstrap.css">
	<!-- Magnific Popup -->
	<link rel="stylesheet" href="css/profile/magnific-popup.css">
	<!-- Theme style  -->
	<link rel="stylesheet" href="css/profile/style.css">
	<!-- font-awesome  -->
	<link rel="stylesheet" href="css/profile/font-awesome.min.css" >
	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

 <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>

	</head>
	<body>
		
	<div class="gtco-loader"></div>
	
	<div id="page">
      <?php include('nav.php');?>
  
<!-- 	<nav class="gtco-nav" role="navigation">
		<div class="container">
			<div class="row">
				<div class="col-xs-8 text-left">
					<div id="gtco-logo"><a href="main.html">コトバと<span>.</span></a></div>
				</div>
				<div class="col-xs-10 text-right menu-1">
					<ul> -->
						<!-- プルダウンできるコード -->
						<!--<li class="has-dropdown">
							<a href="category.html">投稿</a>
							<ul class="dropdown">
								<li><a href="#">Python</a></li>
								<li><a href="#">Javascript</a></li>
								<li><a href="#">HTML5/CSS3</a></li>
								<li><a href="#">Django</a></li>
							</ul>
						</li> -->
<!-- 						<li><a href="#">投稿</a></li>
						<li><a href="#">ジャンル</a></li>
						<li><a href="#">検索</a></li>
						<li><a href="#">プロフィール</a></li>
						<li><a href="#">ログアウト</a></li>
					</ul>
				</div>
			</div>
			
		</div>
	</nav> -->
	
<div id="fh5co-blog-section">
		<div class="container">
			<div class="row" >



<!-- 					フローティングメニューが入る -->
					<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container" >
	<div class="row">
		<div class="col-xs-offset-2 col-xs-8 col-xs-offset-2 col-md-5 col-lg-4" style="margin-left: 0;">

            <div class="card hovercard" style="float:none;margin-top:150px;">
                <div class="cardheader" style="border-top-left-radius: 10px;border-top-right-radius: 10px;">

                </div>
               <div style="background-color: #fff;border-bottom-right-radius: 10px;border-bottom-left-radius: 10px;border-bottom: solid 2px #3B5998;border-right: solid 2px #3B5998;border-left: solid 2px #3B5998;">

                <?php if(!empty($profile_member["picture_path"])){  ?>
                <div class="avatar" style="text-align: center;" style="border-top-left-radius: 10px;border-top-right-radius: 10px;">
                    <img src="picture_path/<?php echo $profile_member["picture_path"];?>" style="object-fit: cover;">
                </div>
                <?php }else{ ?>
                <div class="avatar" style="text-align: center;" style="border-top-left-radius: 10px;border-top-right-radius: 10px;">
                    <img src="picture_path/person-976759_1280.jpg?>" style="object-fit: cover;">
                </div>
                <?php } ?>
                
                <div class="info">
                    <div class="title" style="text-align: center;">
                        <h3 target="_blank" href="#" style="color:black;font-family: arial, sans-serif;font-weight: bold;"><?php echo $profile_member["nick_name"]; ?></h>
                       
                    </div>

                 </div> 


                <div class="bottom" style="text-align: center;font-family: 'Hiragino Kaku Gothic ProN', 'ヒラギノ角ゴ ProN W3', Meiryo, メイリオ, Osaka, 'MS PGothic', arial, helvetica, sans-serif;">
                    <a class="posts" href="profile.php?member_id=<?php echo $profile_member["id"];?>" style="color:#7f7f7f;font-weight: bold;font-family: 'Hiragino Kaku Gothic ProN', 'ヒラギノ角ゴ ProN W3', Meiryo, メイリオ, Osaka, 'MS PGothic', arial, helvetica, sans-serif;font-size: 16px;">投稿</a>
                    <a class="favorite" href="favorite.php?member_id=<?php echo $profile_member["id"];?>" style="color:#7f7f7f;font-weight: bold;font-family: 'Hiragino Kaku Gothic ProN', 'ヒラギノ角ゴ ProN W3', Meiryo, メイリオ, Osaka, 'MS PGothic', arial, helvetica, sans-serif;font-size: 16px;">お気に入り</a>

                    <a href="follows.php?member_id=<?php echo $profile_member["id"];?>" style="color:#7f7f7f;font-weight: bold;font-family: 'Hiragino Kaku Gothic ProN', 'ヒラギノ角ゴ ProN W3', Meiryo, メイリオ, Osaka, 'MS PGothic', arial, helvetica, sans-serif;font-size: 16px;">フォロー</a>
                    <a href="following.php?member_id=<?php echo $profile_member["id"];?>" style="color:#7f7f7f;font-weight: bold;font-family: 'Hiragino Kaku Gothic ProN', 'ヒラギノ角ゴ ProN W3', Meiryo, メイリオ, Osaka, 'MS PGothic', arial, helvetica, sans-serif;font-size: 16px;">フォロワー</a>
                </div>



                	<div class="desc" style="text-align:left;font-weight: bold;margin-left: 5px;font-family: 'Hiragino Kaku Gothic ProN', 'ヒラギノ角ゴ ProN W3', Meiryo, メイリオ, Osaka, 'MS PGothic', arial, helvetica, sans-serif;font-size: 15px;"><?php echo $profile_member["profile"]; ?><br><br>
                	</div>
                </div>
            </div>
        </div>

						<div class="col-xs-12 col-md-7 col-lg-offset-1 col-lg-7" style="margin-top:245px;">
							<div class="mypage-inner">
								
                  <?php foreach($post_list as $one){ ?>
									<div class="col-xs-4 desc col-md-6 col-lg-4" align="center" style="background-color: white;width:200px; height:240px;margin-right: 5px;margin-top: 5px;border-radius:10px;border: 2px solid #3B5998;">

                   <?php if(!empty($one["picture_path"])){ ?>
                   <img class="img-responsive" src="picture_path/<?php echo $one["picture_path"];?>" alt="mypage" style="width:120px; height:120px;border-radius:50%;margin-top: 5px;object-fit: cover;">
                   <?php }else{ ?>
                   <img class="img-responsive" src="picture_path/person-976759_1280.jpg?>" style="width:120px; height:120px;border-radius:50%;margin-top: 5px;object-fit: cover;">
                   <?php } ?>

										<h5 style="font-weight: bold;margin-top: 25px;"><?php echo $one["nick_name"]; ?></h5>

                    <?php if($_SESSION["id"] == $one["follower_id"]){ ?>
                    <?php }elseif($one["following_flag"] == 0){ ?>
                     <a href="following.php?member_id=<?php echo $one["member_id"];?>&follower_id=<?php echo $one["follower_id"]; ?>" ><i class="far fa-hand-point-up" ria-hidden="true" style="font-size: 30px;color:#7f7f7f"></i></a>

                    <?php }else{?>
                    <a href="following.php?member_id=<?php echo $one["member_id"];?>&unfollow_id=<?php echo $one["follower_id"]; ?>"><i class="far fa-hand-point-up" aria-hidden="true" style="color:#DC143C;font-size: 30px;"></i></a>
                    <?php } ?>

                   </div>
                  <?php } ?>
								
									</div>
							</div>
						</div>

				</div>

			</div>
		</div>
	</div>
	
	<footer id="gtco-footer" role="contentinfo">
		<div class="container">
			<div class="row copyright">
				<div class="col-md-12 text-center">
					<p>
						<small class="block" style="margin-top: -25px;">&copy; Copyright © 2018 みねらるうぉーたー. All Rights Reserved.</small> 
					</p>
				</div>
			</div>

		</div>
	</footer>
	</div>

	<div class="gototop js-top">
		<a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
	</div>
	
	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="js/jquery.waypoints.min.js"></script>
	<!-- Stellar -->
	<script src="js/jquery.stellar.min.js"></script>
	<!-- Main -->
	<script src="js/main.js"></script>

	</body>
</html>

