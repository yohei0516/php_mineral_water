<?php 

 session_start();
 require('dbconnect.php');
 require('display.php');
            // echo "<pre>";
            // var_dump($display_list);
            // echo "</pre>";
            // exit;
//GET送信された,member_idをつかって、プロフィール情報をmenbersテーブルから取得する。
// session_idだとログインされている人のIDになってしまう

  $sql = "SELECT * FROM `kotobato_members` WHERE `id`=".$_GET["member_id"];

  $stmt = $dbh->prepare($sql);
  $stmt->execute();

  $profile_member = $stmt->fetch(PDO::FETCH_ASSOC);

// profile.php?member_id=<?php echo $profile_member["id"]);


  // var_dump($profile_member["id"]);
  // exit;

  //一覧データを取得
  $sql = "SELECT `kotobato_posts`.*,`kotobato_members`.`nick_name` FROM `kotobato_posts` INNER JOIN `kotobato_members` ON `kotobato_posts`.`member_id`=`kotobato_members`.`id` WHERE `delete_flag`=0 AND `kotobato_posts`.`member_id`=".$_GET["member_id"]." ORDER BY `kotobato_posts`.`modified` DESC ";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  // 一覧表示用の配列を用意
  $post_list = array();
  //　複数行のデータを取得するためループ
  while (1) {
    $one_post = $stmt->fetch(PDO::FETCH_ASSOC);

  //     var_dump($one_post);
  // exit;
    if ($one_post == false){
      break;
    }else{
      //データが取得できている
      $post_list[] = $one_post;
    }
  }

      //自分もフォローしていたら１、フォローしていなかったら０を取得。
      $fl_flag_sql = "SELECT COUNT(*) as `cnt` FROM `kotobato_follows` WHERE `member_id`=".$_SESSION["id"]." AND `follower_id`=".$_GET["member_id"];
      $fl_stmt = $dbh->prepare($fl_flag_sql);
      $fl_stmt->execute();
      $fl_flag = $fl_stmt->fetch(PDO::FETCH_ASSOC);

  //     var_dump($fl_flag);
  // exit;

//フォロー処理
// profile.php?follow_id=7 というリンクが推された＝フォローボタンが押された
  if (isset($_GET["follow_id"])){
    //follow情報を記録するSQL文を作成
    $sql = "INSERT INTO `kotobato_follows` (`member_id`, `follower_id`) VALUES (?, ?);";
    $data = array($_SESSION["id"],$_GET["follow_id"]);
    $fl_stmt = $dbh->prepare($sql);
    $fl_stmt->execute($data);
       //フォロー解除を押す前の状態に戻す
    header("Location: profile.php?member_id=".$_GET['member_id']);
  }

//フォロー解除処理
  if(isset($_GET["unfollow_id"])){
    // フォロー情報を削除するSQLを作成
    $sql = "DELETE FROM `kotobato_follows` WHERE `member_id`=? AND `follower_id`=?";
    $data = array($_SESSION["id"],$_GET["unfollow_id"]);
    $unfl_stmt = $dbh->prepare($sql);
    $unfl_stmt->execute($data);

    //フォロー解除を押す前の状態に戻す
    header("Location: profile.php?member_id=".$_GET['member_id']);
  }

            // echo "<pre>";
            // var_dump($_GET);
            // echo "</pre>";

            // exit;

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


<style>


</style>
	</head>
	<body>
		
	<div class="gtco-loader"></div>
	
	<div id="page">
	<nav class="gtco-nav" role="navigation">
		<div class="container">
			<div class="row">
				<div class="col-xs-8 text-left">
					<div id="gtco-logo"><a href="main.html">コトバと<span>.</span></a></div>
				</div>
				<div class="col-xs-10 text-right menu-1">
					<ul>
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
						<li><a href="#">投稿</a></li>
						<li><a href="#">ジャンル</a></li>
						<li><a href="#">検索</a></li>
						<li><a href="#">プロフィール</a></li>
						<li><a href="#">ログアウト</a></li>
					</ul>
				</div>
			</div>
			
		</div>
	</nav>
	
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

               <div class="background" style="background-color: #fff;border-bottom-right-radius: 10px;border-bottom-left-radius: 10px;border-bottom: solid 2px #3B5998;border-right: solid 2px #3B5998;border-left: solid 2px #3B5998;">


                <div class="avatar" style="text-align: center;" style="border-top-left-radius: 10px;border-top-right-radius: 10px;">
                    <img src="picture_path/<?php echo $profile_member["picture_path"];?>" style="object-fit: cover;">
                </div>

                <div class="info">
                    <div class="title" style="text-align: center;">
                        <h3 target="_blank" href="#" style="color:black;font-family: arial, sans-serif;font-weight: bold;"><?php echo $profile_member["nick_name"]; ?></h>
                         <?php if($_SESSION["id"] == $profile_member["id"]){ ?>
                        <a href="edit.php?member_id=<?php echo $profile_member["id"];?>" style="font-size:15px;color:black;font-family: arial, sans-serif;"><br>プロフィールを編集</a>
                         <?php }?> 
                    </div>
                </div>

					        <?php if($_SESSION["id"] != $profile_member["id"]){ ?>

					        <?php if($fl_flag["cnt"] == 0){ ?>
					        <a href="profile.php?member_id=<?php echo $profile_member["id"]; ?>&follow_id=<?php echo $profile_member["id"];?>">
					        <button class="btn btn-block btn-default">フォロー</button>
					        </a>
					        <?php }else{ ?>

					        <a href="profile.php?member_id=<?php echo $profile_member["id"]; ?>&unfollow_id=<?php echo $profile_member["id"];?>">
					        <button class="btn btn-block btn-default">フォロー解除</button>
					        </a>
					        <?php } ?>
					        <?php } ?>

                <div class="bottom" style="text-align: center;">
                    <a class="posts" href="profile.php?member_id=<?php echo $profile_member["id"];?>" style="color:#7f7f7f;font-weight: bold;">投稿</a>
                    <a class="favorite" href="favorite.php?member_id=<?php echo $profile_member["id"];?>" style="color:#7f7f7f;font-weight: bold;">お気に入り</a>

          <a href="follows.php?member_id=<?php echo $profile_member["id"];?>">フォロー</a>
          <a href="following.php?member_id=<?php echo $profile_member["id"];?>">フォロワー</a>
                </div>

                	<div class="desc" style="text-align:left;border-color:black;border:5px;border-radius: 5px;font-weight: bold;margin-left: 5px;"><?php echo $profile_member["profile"]; ?><br><br>
                	</div>

                </div>
            </div>
        </div>

						<div class="col-xs-12 col-md-7 col-lg-offset-1 col-lg-7" style="margin-top:245px;">
							<div class="mypage-inner">

                  <?php foreach ($display_list as $post) {
                   if($post["member_id"] == $profile_member["id"]) { ?>

									<div class="desc" style="background-color: white;">
									<a href="#"><img class="img-responsive" align="left" src="post_picture/<?php echo $post["post_picture"];?>" alt="mypage" style="margin-right: 15px;margin-top: 20px;width: 200px;height: 150px;object-fit: cover;"></a>
										<br>
										<h3 align="left" style="font-weight: bold;"><?php echo $post["word"]; ?></h3>
										<p  align="left" style="font-weight: bold;"><?php echo $post["explanation"]; ?></p>
										<br>

                  <?php if ($post["login_like_flag"] == 0){?>
                  <a href="like.php?like_post_id=<?php echo $post["id"];?>&page=<?php echo $page;?>"><p align="right" style="margin-bottom:5px;">いいね<a class="fa fa-leaf" aria-hidden="true" style="color:black"></a></a>
                  <?php }else{?>

                  <a href="like.php?unlike_post_id=<?php echo $post["id"];?>&page=<?php echo $page; ?>"><p align="right" style="margin-bottom:5px;">だめだね<a class="fa fa-leaf" aria-hidden="true" style="color:red"></a></a>
                  <?php } ?>
                  <?php if($post["like_count"] > 0){echo $post["like_count"];} 

                    if($post["login_favorite_flag"] == 0){?>
                  <a href="favorite_function.php?favorite_post_id=<?php echo $post["id"];?>&page=<?php echo $page;?>">お気に入り</a>
                  <?php }else{?>
                  <a href="favorite_function.php?unfavorite_post_id=<?php echo $post["id"];?>&page=<?php echo $page; ?>">気に入らない</a>
                  <?php }

                  if($_SESSION["id"] == $post["member_id"]){ ?>
                  [<a onclick="return confirm('削除します、よろしいですか？');" href="delete.php?id=<?php echo $post["id"]; ?>" style="color: black;">削除</a>]
                   <?php }?>  
                <?php }?> 
<!-- 										<p align="right" style="margin-bottom:5px;"><a class="fa fa-leaf" aria-hidden="true" style="color:black"></a><a href="#" align="right" style="color:black;" class="fa fa-star-o" aria-hidden="true"></a></p> -->
									</div>
                 <?php } ?>

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

