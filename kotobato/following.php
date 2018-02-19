<?php 
  session_start();
  // DBの接続
  require('dbconnect.php');

  // ログインしている人のプロフィール情報をmembersテーブルから取得
  $sql = "SELECT * FROM `kotobato_members` WHERE `id`=".$_SESSION["id"];
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $profile_member = $stmt->fetch(PDO::FETCH_ASSOC);
  // var_dump($_SESSION);
  // exit;
  //一覧データを取得
  $sql = "SELECT * FROM `kotobato_members` INNER JOIN `kotobato_follows` ON `kotobato_members`.`id` = `kotobato_follows`.`follower_id` WHERE `kotobato_follows`.`member_id` = ".$_SESSION["id"]." ORDER BY `kotobato_follows`.`created` DESC";

  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  // 一覧表示用の配列を用意
  $post_list = array();
  //　複数行のデータを取得するためループ
  while (1) {
    $one_post = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($one_post);
    // exit;
    if ($one_post == false){
      break;
    }else{
      //データが取得できている
      $post_list[] = $one_post;

    }
  }

//フォロー処理
// profile.php?follow_id=7 というリンクが推された＝フォローボタンが押された
  if (isset($_GET["follow_id"])){
    //follow情報を記録するSQL文を作成
    $sql = "INSERT INTO `kotobato_follows` (`member_id`,`follower_id`) VALUES (?, ?);";
    $data = array($_SESSION["id"],$_GET["follow_id"]);
    $fl_stmt = $dbh->prepare($sql);
    $fl_stmt->execute($data);
    //フォロー押す前の状態に戻す（再読込で、再度フォロー処理が動くのを防ぐ）
    header("Location: follows.php");
  }

//フォロー解除処理
  if(isset($_GET["unfollow_id"])){
    // フォロー情報を削除するSQLを作成
    $sql = "DELETE FROM `kotobato_follows` WHERE `member_id`=? AND `follower_id`=?";
    $data = array($_SESSION["id"],$_GET["unfollow_id"]);
    $unfl_stmt = $dbh->prepare($sql);
    $unfl_stmt->execute($data);

    //フォロー解除を押す前の状態に戻す
    header("Location: following.php");

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
               <div style="background-color: #fff;border-bottom-right-radius: 10px;border-bottom-left-radius: 10px;border-bottom: solid 2px #3B5998;border-right: solid 2px #3B5998;border-left: solid 2px #3B5998;">
                <div class="avatar" style="text-align: center;">
                    <img alt="" src="images/image_7.jpg" >
                </div>
                <div class="info">
                    <div class="title" style="text-align: center;">
                        <h3 target="_blank" href="#" style="color:black;font-family: arial, sans-serif;font-weight: bold;">レベッカ</h>
                        <a href="#" style="font-size:15px;color:black;font-family: arial, sans-serif;"><br>プロフィールを編集</a>
                    </div>

                 </div> 
                <div class="bottom" style="text-align: center;">
                    <a class="posts" href="#" value="投稿" style="color:#7f7f7f;font-weight: bold;">投稿</a>
                    <a class="favoritte" href="#" value="お気に入り" style="color:#7f7f7f;font-weight: bold;">お気に入り</a>
                    <a class="follows"　href="#" value="フォロー" style="color:#7f7f7f;font-weight: bold;">フォロー</a>
                    <a class="following"　href="#" value="フォロワー" style="color:#7f7f7f;font-weight: bold;">フォロワー</a>
                </div>
                	<div class="desc" style="text-align:left;font-weight: bold;margin-left: 5px;">デジタルハリウッド大学中退<br>職業：校長先生が話す前に子供を静かにさせる<br>やる気、元気、殺意！<br><br>
                	</div>
                </div>
            </div>
        </div>

						<div class="col-xs-12 col-md-7 col-lg-offset-1 col-lg-7" style="margin-top:245px;">
							<div class="mypage-inner">
								
								<?php foreach ($post_list as $one_post) { ?> 
									<div class="col-xs-4 desc col-md-6 col-lg-4" align="center" style="background-color: white;width:200px; height:240px;margin-right: 5px;margin-top: 5px;border-radius:10px;border: 2px solid #3B5998;">
										<img class="img-responsive" src="images/image_1.jpg" alt="mypage" style="width:120px; height:120px;border-radius:50%;margin-top: 5px;">
										<h5 style="font-weight: bold;margin-top: 25px;"><?php echo $one_post["nick_name"]; ?></h5>
										<a href="following.php?unfollow_id=<?php echo $one_post["follower_id"]; ?>">
					          <button class="btn btn-default">フォロー解除</button>
					          </a>    
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

