<?php
  require('function.php');
  require('dbconnect.php');
  login_check();
  require('display.php');

  // DBの接続

  // ログインしている人のプロフィール情報をmembersテーブルから取得
  $sql = "SELECT * FROM `kotobato_members` WHERE `id`=".$_SESSION["id"];
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $favorite_member = $stmt->fetch(PDO::FETCH_ASSOC);
  //   var_dump($profile_member);
  // exit;
            // echo "<pre>";
            // var_dump($_GET);
            // echo "</pre>";
            // exit;
  //一覧データを取得
  // $sql_fv = "SELECT * FROM `kotobato_favorites`WHERE `member_id`=".$_GET["id"]." ORDER BY `kotobato_favorites`.`created` DESC";
  // $stmt_fv = $dbh->prepare($sql_fv);
  // $stmt_fv->execute();


  $sql_ps = "SELECT `kotobato_posts`.*,`kotobato_favorites`.`member_id`,`kotobato_favorites`.`post_id` FROM `kotobato_posts` INNER JOIN `kotobato_favorites` ON `kotobato_posts`.`id`=`kotobato_favorites`.`post_id` WHERE `delete_flag`=0 AND `kotobato_favorites`.`member_id` =".$_GET["id"]." ORDER BY `kotobato_posts`.`modified` DESC ";

  // "ORDER BY `kotobato_posts`.`modified` DESC"

     $stmt_ps = $dbh->prepare($sql_ps);
     $stmt_ps->execute();
            // echo "<pre>";
            // var_dump($_GET);
            // echo "</pre>";
            // exit;
  // 一覧表示用の配列を用意
  $post_list = array();

           // echo "<pre>";
           //  var_dump($favorite_post);
           //  echo "</pre>";
           //  exit;

        // var_dump($one_post);
  //　複数行のデータを取得するためループ
  while (1) {
    $one_post = $stmt_ps->fetch(PDO::FETCH_ASSOC);
        // var_dump($one_post);
        // exit;
    if ($one_post == false){
      break;
	    }else{

      $like_sql = "SELECT COUNT(*)as `like_count` FROM `kotobato_likes` WHERE `post_id`=".$one_post["member_id"];
      // SQL文実行
      $like_stmt = $dbh->prepare($like_sql);
      $like_stmt->execute();
      $like_number = $like_stmt->fetch(PDO::FETCH_ASSOC);
      //1行分のデータに新しいキーを用意して、like数を代入
      $one_post["like_count"] = $like_number["like_count"];
      // ログインしている人がLikeしているかどうかの情報を取得
      $login_like_sql = "SELECT COUNT(*) as `like_count` FROM `kotobato_likes` WHERE `post_id`=".$one_post['member_id']." AND `member_id` =".$_SESSION["id"];
      // SQL文実行
      $login_like_stmt = $dbh->prepare($login_like_sql);
      $login_like_stmt->execute();

      // フェッチして取得
      $login_like_number = $login_like_stmt->fetch(PDO::FETCH_ASSOC);
      $one_post["login_like_flag"] = $login_like_number["like_count"];



      // like数を求めるSQL文
      $favorite_sql = "SELECT COUNT(*)as `favorite_count` FROM `kotobato_favorites` WHERE `post_id`=".$one_post["member_id"];
      // SQL文実行
      $favorite_stmt = $dbh->prepare($favorite_sql);
      $favorite_stmt->execute();
      $favorite_number = $favorite_stmt->fetch(PDO::FETCH_ASSOC);
      //1行分のデータに新しいキーを用意して、like数を代入
      $favorite_post["favorite_count"] = $favorite_number["favorite_count"];
      // ログインしている人がLikeしているかどうかの情報を取得
      $login_favorite_sql = "SELECT COUNT(*) as `favorite_count` FROM `kotobato_favorites` WHERE `post_id`=".$one_post['member_id']." AND `member_id` =".$_SESSION["id"];
      // SQL文実行
      $login_favorite_stmt = $dbh->prepare($login_favorite_sql);
      $login_favorite_stmt->execute();

      // フェッチして取得
      $login_favorite_number = $login_favorite_stmt->fetch(PDO::FETCH_ASSOC);
      $one_post["login_favorite_flag"] = $login_favorite_number["favorite_count"];


	    	$sql_fv = "SELECT * FROM `kotobato_members` WHERE `id`=".$one_post["member_id"];
	    	$stmt_fv = $dbh->prepare($sql_fv);
  			$stmt_fv->execute();
  			$member = $stmt_fv->fetch(PDO::FETCH_ASSOC);


  			$one_post["nick_name"] = $member["nick_name"];

	    	$post_list[] = $one_post;

	    }
		}
  //     //following_flagを用意して、自分もフォローしていたら1,フォローしてなかったら0を代入する
  //     $fv_flag_sql = "SELECT COUNT(*) as `cnt` FROM `kotobato_favorites` WHERE `member_id`=".$_SESSION["id"]." AND `member_id`=".$favorite_post["member_id"];
  //     $fv_stmt = $dbh->prepare($fv_flag_sql);
  //     $fv_stmt->execute();
  //     $fv_flag = $fv_stmt->fetch(PDO::FETCH_ASSOC);
  //     //一覧の時に必要
  //     $favorite_post["favorite_flag"]=$fv_flag["cnt"];
  //     //データが取得できている


  //     $favorites_list[] = $favorite_post;
  //   }
  // }

            // echo "<pre>";
            // var_dump($display_list);
            // echo "</pre>";
            // exit;
// $display_list[] = array_values($one_list);

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
                <div class="cardheader">

                </div>
               <div class="background" style="background-color: #fff;">
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
                    <a class="favorite" href="#" value="お気に入り" style="color:#7f7f7f;font-weight: bold;">お気に入り</a>
                    <a class="follows"　href="#" value="フォロー" style="color:#7f7f7f;font-weight: bold;">フォロー</a>
                    <a class="following"　href="#" value="フォロワー" style="color:#7f7f7f;font-weight: bold;">フォロワー</a>
                </div>
                	<div class="desc" style="text-align:left;border-color:black;border:5px;border-radius: 5px;background-color: #fff;font-weight: bold;">デジタルハリウッド大学中退<br>職業：校長先生が話す前に子供を静かにさせる<br>やる気、元気、殺意！<br><br><br><br></div>
                </div>
            </div>
        </div>

						<div class="col-xs-12 col-md-7 col-lg-offset-1 col-lg-7" style="margin-top:245px;">
							<div class="mypage-inner">


<!-- <?php 
foreach ($post_list as $post) {
  foreach ($favorite as $f) {
    if $post["id"] = $f["id"] {
      $post["favorite"] = $f
    }
    # code...
  }
}


 ?> -->

								<?php foreach ($post_list as $post) {  ?>

									<div class="desc" style="background-color: white;">
									<a href="#"><img class="img-responsive" align="left" src="post_picture/<?php echo $post["post_picture"];?>" alt="mypage" style="margin-right: 15px;margin-top: 20px;object-fit: cover;width: 200px;height: 150px;"></a>
										<br>
										<h3 align="left" style="font-weight: bold;"><?php echo $post["word"]; ?></h3>
										<p  align="left" style="font-weight: bold;"><?php echo $post["explanation"]; ?></p>
										<br>
										<p align="right" style="margin-bottom:5px;"><a class="fa fa-leaf" aria-hidden="true" style="color:black"></a><a href="#" align="right" style="color:black;" class="fa fa-star-o" aria-hidden="true"></a></p>
									</div>

									  <div class="col-lg-12 col-md-12 col-xs-12">
      							<a href="profile.php?member_id=<?php echo $post["member_id"];?>"><br>
      		          <?php echo $post["nick_name"]; ?>
      		          </a>

      							<?php if ($post["login_like_flag"] == 0){?>
      							<a href="like.php?like_post_id=<?php echo $post["member_id"];?>&page=<?php echo $page; ?>" class="post-meta">いいね</a>
      							<?php }else{?>

      							<a href="like.php?unlike_post_id=<?php echo $post["member_id"];?>&page=<?php echo $page; ?>">だめだね</a>
                    <?php } ?>
                    <?php if($post["like_count"] > 0){echo $post["like_count"];} ?>
      							
                    <?php if($post["login_favorite_flag"] == 0){?>
                    <a href="favorite_function.php?favorite_post_id=<?php echo $post["id"];?>&page=<?php echo $page;?>">お気に入り</a>
                    <?php }else{?>
                    <a href="favorite_function.php?unfavorite_post_id=<?php echo $post["id"];?>&page=<?php echo $page; ?>">気に入らない</a>
                    <?php } ;

                     if($_SESSION["id"] == $post["member_id"]){ ?>
                     [<a onclick="return confirm('削除します、よろしいですか？');" href="delete.php?id=<?php echo $post["id"]; ?>" style="color: black;">削除</a>]
                     <?php }?>
                     </div>

   							<?php 
   					} ?>
									
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

