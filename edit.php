<?php 
require('function.php');

// ログインチェック
login_check();
require('dbconnect.php');

// var_dump($profile_member);
//   exit;
$sql = "SELECT * FROM `kotobato_members` WHERE `id`=".$_GET["member_id"];
$stmt = $dbh->prepare($sql);
$stmt->execute();

$profile_member = $stmt->fetch(PDO::FETCH_ASSOC);


 if (isset($_POST) && !empty($_POST)){

     if ($_POST["nick_name"] == ""){
      $error["nick_name"] = "blank";
    }
     if ($_POST["email"] == ""){
      $error["email"] = "blank";
    }
     if ($_POST["password"] == ""){
      $error["password"] = "blank";
    }elseif(strlen($_POST["password"]) < 4){
     $error["password"] = 'length';
    }

    $nick_name = $_POST['nick_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $profile = $_POST['profile'];

    $member_id = $_SESSION['id'];

            //           echo "<pre>";
            // var_dump($_FILES);
            // echo "</pre>";
            // exit;
if(!isset($error)){
      try{
        //検索条件にヒットした件数を取得するSQL文
        $sql = "SELECT COUNT(*) as `cnt` FROM `kotobato_members` WHERE `email` =?";

        //sql文実行;
        $data = array($_POST["email"]);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        //件数取得
        $count = $stmt->fetch(PDO::FETCH_ASSOC);

        if($count['cnt'] > 0){
          //重複エラー
          $error['email'] = "duplicated";

      }

      }catch(Exception $e){
        exit;
      }
      
      $ext = substr($_FILES['picture_path']['name'],-3);
      if(($ext == 'png') || ($ext == 'jpg') || ($ext == 'gif')){
      //画像のアップロード処理
      //例）eriko1.pngを指定したとき　$picture_nameの中身は20171222142530eriko1.pngというような文字列が代入される。
      //ファイル名の決定
      $picture_name = date('YmdHis') . $_FILES['picture_path']['name'];
      //アップロード（フォルダに書き込み権限がないと、保存されない！！）
      // アップロードしたいファイル、サーバーのどこにどういう名前でアップロードするか指定
      move_uploaded_file($_FILES['picture_path']['tmp_name'],'picture_path/'.$picture_name);

    // SESSION変数に入力された値を保存
    // 注意！必ず、ファイルの一番上に、session_strat();と書く
    // POST送信された情報をjoinというキー指定で保存
        $_SESSION['join'] = $_POST;
        $_SESSION['join']['picture_path'] = $picture_name;

        $picture_path = $_SESSION['join']['picture_path'];
      }

        // 特にアクションがなくても保持して
        $post_id = $_GET['id'];

         $sql = "UPDATE `kotobato_members` SET `nick_name`=?,`email`=?,`password`=?,`picture_path`=?,`profile`=? WHERE `id`=".$_SESSION["id"];

          $data = array($nick_name,$email,sha1($password),$picture_path,$profile);
             // var_dump($_POST); 
          $stmt = $dbh->prepare($sql);
          $members = $stmt->execute($data);       
      }


      if($members == false){
        //認証失敗
        $error["login"] = "failed";
      }else{
        //認証成功
        //　１．セッション変数に会員idを保存
        $_SESSION["id"] = $members["id"];

        //２．ログインした時間をセッション変数の保存
        $_SESSION["time"] = time();

        header("Location: main.php");
        exit; 

      }
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
               <div class="background" style="background-color: #fff;border-bottom-right-radius: 10px;border-bottom-left-radius: 10px;border-bottom: solid 2px #3B5998;border-right: solid 2px #3B5998;border-left: solid 2px #3B5998;">
                <div class="avatar" style="text-align: center;">
                    <img alt="" src="picture_path/<?php echo $profile_member["picture_path"];?>" style="object-fit: cover;">
                </div>
                <div class="info">
                    <div class="title" style="text-align: center;">
                        <h3 target="_blank" href="#" style="color:black;font-family: arial, sans-serif;font-weight: bold;"><?php echo $profile_member["nick_name"]; ?></h>
                       
                    </div>

                </div>
                <div class="bottom" style="text-align: center;">
                    <a class="posts" href="profile.php?member_id=<?php echo $profile_member["id"];?>" style="color:#7f7f7f;font-weight: bold;">投稿</a>
                    <a class="favorite" href="favorite.php?member_id=<?php echo $profile_member["id"];?>" style="color:#7f7f7f;font-weight: bold;">お気に入り</a>

          <a href="follows.php?member_id=<?php echo $profile_member["id"];?>">フォロー</a><a href="following.php?member_id=<?php echo $profile_member["id"];?>">フォロワー</a>
                </div>
                	<div class="desc" style="text-align:left;font-weight: bold;margin-left: 5px;"><?php echo $profile_member["profile"]; ?><br><br></div>
                </div>
            </div>
        </div>

						<div class="col-xs-12 col-md-7 col-lg-offset-1 col-lg-7" style="margin-top:245px;">
							<div class="mypage-inner" style="height:750px;background-color: #fff;border-radius:15px;border: 2px solid #3B5998;">
							 <div>
								<h3 style="font-weight: bold;margin-left: 15px;" align="left"><br>プロフィール</h3>
								<hr>
							</div>
							<div class="col-xs-4 col-md-4 col-lg-4" arign="left">
								<h4>プロフィール画像</h4>
							<p align="left" style="font-weight: bold;margin-left: 10px;margin-top: 15px;"></p>
							</div>

							<div>
								<img class="img-responsive" src="picture_path/<?php echo $profile_member["picture_path"];?>" alt="mypage" style="text-align:center;height:120px;width:120px;color:#7f7f7f;border-radius:50%;object-fit: cover;>
							</div>
              <form method="post" action="" enctype="multipart/form-data" role="form">

							<div class="col-xs-offset-8 col-xs-4 col-md-offset-8 col-md-4 col-lg-offset-8 col-lg-4">
<!-- 								<button  class="button" style="border-radius: 100px;box-shadow: none;cursor: pointer;font-size:14px;font-weight:400;line-height: 20px;padding: 6px,16px;position: relative;text-align:center;white-space: nowrap;color: #fff;background-color: #3B5998;font: inherit;border-color:#fff;height: 40px;width: 100px;">画像を選択</button> -->
                <input type="file" name="picture_path" class="form-control" >

							</div>
              <br><br><br><br>
							<div>	

    							<div class="col-xs-3 col-md-3 col-lg-3">
        					<h5 style="margin-top: 7px;margin-left: 5px;">ニックネーム</h5>
                  <?php if((isset($error["nick_name"])) && ($error["nick_name"]=='blank')){ ?>
                  <p class="error" style="color: red;">※ニックネームを入力してください。</p>
                  <?php } ?>
        					</div>

        					<div class="col-xs-9 col-md-9 col-lg-9">
        						<input type="text" name="nick_name" style="width:200px">
                  </div>
                  <br><br><br>
        					<div class="col-xs-3 col-md-3 col-lg-3" >
       						<h5 style="margin-top: 7px;margin-left: 5px;">メールアドレス</h5>
                  <?php if((isset($error["nick_name"])) && ($error["nick_name"]=='blank')){ ?>
                  <p class="error" style="color: red;">※メールアドレスを入力してください。</p>
                  <?php } ?>
                  <?php if(isset($error["email"]) && $error["email"]=='duplicated'){ ?>
                  <p class="error" style="color: red;">※入力されたEmailは登録済みです。</p>
                  <?php } ?>
       						</div>

                  <div class="col-xs-9 col-md-9 col-lg-9">
                    <input type="text" name="email" style="width: 200px">
                  </div>
                  <br><br><br>
       						<div class="col-xs-3 col-md-3 col-lg-3">
       						<h5 style="margin-top: 7px;margin-left: 5px;">パスワード</h5>
                  <?php if(isset($error["password"]) && $error["password"]=='blank'){ ?>
                  <p class="error" style="color: red;">*　パスワードを入力してください。</p>
                  <?php }elseif(isset($error["password"]) && $error["password"]=='length'){?>
                  <p class="error" style="color: red;">※パスワードは４文字以上を入力してください。</p>
                  <?php } ?>
       						</div>

                  <div class="col-xs-9 col-md-9 col-lg-9">
                    <input type="text" name="password" style="width: 200px">
                  </div>
                  <br><br><br>

       						<div class="col-xs-3 col-md-3 col-lg-3">
        						<h5 style="margin-top: 7px;margin-left: 5px;">自己紹介</h5>
    							</div>
                  <textarea class="col-xs-9 col-md-9 col-lg-9" name="profile" cols="40" rows="5" style="width: 200px;margin-left: 15px;"></textarea>
                  <br><br><br>	
 								
                 <br><br><br><br>

                 <div class="col-xs-offset-8 col-xs-4 col-md-offset-8 col-md-4 col-lg-offset-8 col-lg-4">
                 <input type="submit" value="変更する" style="border-radius: 100px;box-shadow: none;cursor: pointer;font-size:14px;font-weight:400;line-height: 20px;padding: 6px,16px;position: relative;text-align:center;white-space: nowrap;color: #fff;background-color: #7f7f7f;font: inherit;border-color:#fff;height: 40px;width: 100px;">
                 </div>

                  </form>
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

