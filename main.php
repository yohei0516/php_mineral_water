<?php 
  require('function.php');
  login_check();
  //DBの接続
  require('dbconnect.php');


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
    $sql = "SELECT `kotobato_posts`.*,`kotobato_members`.`nick_name` FROM `kotobato_posts` INNER JOIN `kotobato_members` ON `kotobato_posts`.`member_id`=`kotobato_members`.`id` WHERE `delete_flag`=0 ORDER BY `kotobato_posts`.`modified` DESC LIMIT ".$start.",".$page_row;

     $stmt = $dbh->prepare($sql);
     $stmt->execute();

     // 一覧表示用の配列を用意
     $post_list = array();

     // 複数行のデータを取得するためループ
     while (1) {
      $one_post = $stmt->fetch(PDO::FETCH_ASSOC);
      // var_dump($one_post);
      if($one_post == false){
      break;
     }else{

      // like数を求めるSQL文
      $like_sql = "SELECT COUNT(*)as `like_count` FROM `kotobato_likes` WHERE `post_id`=".$one_post["id"];

      // SQL文実行
      $like_stmt = $dbh->prepare($like_sql);
      $like_stmt->execute();
      $like_number = $like_stmt->fetch(PDO::FETCH_ASSOC);


      // $one_tweetの中身
      // $one_tweet["tweet"]つぶやき
      // $one_tweet["member_id"]つぶやいた人のid
      // $one_tweet["nick_name"]つぶやいた人のニックネーム
      // $one_tweet["picture_path"]つぶやいた人のプロフィール画像
      // $one_tweet["modified"]つぶやいた日時

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

// var_dump($one_post["login_like_flag"]);

      // データが取得できている
      $post_list[] = $one_post;
      // var_dump($post_list);
      // exit;
     }
     // var_dump($one_post);
    }


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


    //     // var_dump($follower);
    //タグの一覧を取得
    // $tag_sql = "SELECT * FROM `kotobato_hashtag`";
    // $tag_stmt = $dbh->prepare($tag_sql);
    // $tag_stmt->execute();
    // $tag_list = array();
    // var_dump($tag_list);
//     while(1){
//       $one_tag = $tag_stmt->fetch(PDO::FETCH_ASSOC);
// // var_dump($tag_stmt);
//       if($one_tag == false){
//         break;
//       }
//       $tag_list[] = $one_tag;
//     }
   }catch(Exception $e){
   	echo 'SQL実行エラー:'.$e->getMessage();
    exit();
  }
// var_dump($one_post);
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
	<link rel="stylesheet" href="css/main/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/main/icomoon.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/main/bootstrap.css">
	<!-- Magnific Popup -->
	<link rel="stylesheet" href="css/main/magnific-popup.css">
	<!-- Theme style  -->
	<link rel="stylesheet" href="css/main/style.css">
	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<!-- モーダルウィンドウ -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  	<script src="js/login.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

	</head>
	<body>
		
	<div class="gtco-loader"></div>
	
	<div id="page">
	<nav class="gtco-nav" role="navigation">
		<div class="container">
			<div class="row">
				<div class="col-xs-2 text-left">
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
						<li><a id="modal-open" class="buttons button button-link">投稿</a></li>
						<li><a href="#">ジャンル</a></li>
						<li><a href="#">検索</a></li>
						<li><a href="#">プロフィール</a></li>
						<li><a href="index.php">ログアウト</a></li>
					</ul>
				</div>
			</div>
			
		</div>
	</nav>

	<header>
<!-- 	<header id="gtco-header" class="gtco-cover" role="banner" style="background-image:url(images/img_1.jpg);" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-7 text-left">
					<div class="display-t">
						<div class="display-tc animate-box" data-animate-effect="fadeInUp">
							<span class="date-post">4 days ago</span>
							<h1 class="mb30"><a href="#">How Web Hosting Can Impact Page Load Speed</a></h1>
							<p><a href="#" class="text-link">Read More</a></p>
						</div>
					</div>
				</div>
			</div>
		</div> -->
	</header>
	
	<div id="gtco-main">
		<div class="container">
			<div class="row row-pb-md">
				<div class="msg_header">
          <a href="follows.php">Followers<span class="badge badge-pill badge-default"><?php echo $follower["cnt"]; ?></span></a><a href="following.php">Following<span class="badge badge-pill badge-default"><?php echo $following["cnt"]; ?></span></a>
        </div>
				<div class="col-md-12">					
					<ul id="gtco-post-list">
						<?php foreach ($post_list as $one_post) {?>
						<li class="full entry animate-box" data-animate-effect="fadeIn">
							<a href="picture_path/<?php echo $one_post["post_picture"];?>">
								<div class="entry-img" style="background-image: url(images/img_1.jpg"></div>
								<div class="entry-desc">
									<h3><?php echo $one_post["word"]; ?></h3><br>
									<p><?php echo $one_post["explanation"]; ?></p>
								</div>
							</a>

							<a href="profile.php?member_id=<?php echo $one_post["member_id"];?>">
		          <?php echo $one_post["nick_name"]; ?>
		          </a>

							<?php if ($one_post["login_like_flag"] == 0){?>
							<a href="like.php?like_post_id=<?php echo $one_post["id"];?>&page=<?php echo $page; ?>" class="post-meta">いいね</a>
							<?php }else{?>

							<a href="like.php?unlike_post_id=<?php echo $one_post["id"];?>&page=<?php echo $page; ?>">だめだね</a>
              <?php } ?>
              <?php if($one_post["like_count"] > 0){echo $one_post["like_count"];} ?>
							<span class="date-posted">お気に入り保存</span>
						</li>
						<?php } ?>

						<li class="two-third entry animate-box" data-animate-effect="fadeIn"> 
							<a href="images/img_2.jpg">
								<div class="entry-img" style="background-image: url(images/img_2.jpg"></div>
								<div class="entry-desc">
									<h3>Stay Hungry. Stay Foolish.</h3> <br>
									<p>It wasn't all romantic. I didn't have a dorm room, so I slept on the floor in friends' rooms, I returned coke bottles for the 5¢ deposits to buy food with, and I would walk the 7 miles across town every Sunday night to get one good meal a week at the Hare Krishna temple. I loved it. And much of what I stumbled into by following my curiosity and intuition turned out to be priceless later on. Let me give you one example:</p>
								</div>
							</a>
							<a href="single.html" class="post-meta">いいね  <span class="date-posted">お気に入り保存</span></a>
						</li>

						<li class="one-third entry animate-box" data-animate-effect="fadeIn">
							<a href="images/img_3.jpg">
								<div class="entry-img" style="background-image: url(images/img_3.jpg"></div>
								<div class="entry-desc">
									<h3>Time flies so quickly!!!</h3> <br>
									<p>この地上で過ごせる時間には限りがあります。<br>	
										本当に大事なことを本当に一生懸命できる機会は、
										二つか三つくらいしかないのです。   </p>
								</div>
							</a>
							<a href="single.html" class="post-meta">いいね  <span class="date-posted">お気に入り保存</span></a>
						</li>

						<li class="one-third entry animate-box" data-animate-effect="fadeIn">
							<a href="images/img_4.jpg">
								<div class="entry-img" style="background-image: url(images/img_4.jpg"></div>
								<div class="entry-desc">
									<h3>戯れて生きるな</h3>
									<p>あなたの時間は限られている。だから、誰かほかの人の人生を生きることでムダな時間を費やさないでほしい。  </p>
								</div>
							</a>
							<a href="single.html" class="post-meta">いいね  <span class="date-posted">お気に入り保存</span></a>
						</li>
						<li class="one-third entry animate-box" data-animate-effect="fadeIn">
							<a href="images/img_5.jpg">
								<div class="entry-img" style="background-image: url(images/img_5.jpg"></div>
								<div class="entry-desc">
									<h3>音楽に生きる</h3>
									<p>生きることは音楽的であること。体内の血が踊り出すところから始まるすべての生命がリズムを刻んでいる。君は音楽を感じているか？ </p>
								</div>
							</a>
							<a href="single.html" class="post-meta">いいね  <span class="date-posted">お気に入り保存</span></a>
						</li>
						<li class="one-third entry animate-box" data-animate-effect="fadeIn">
							<a href="images/img_6.jpg">
								<div class="entry-img" style="background-image: url(images/img_6.jpg"></div>
								<div class="entry-desc">
									<h3>もっと単純に</h3>
									<p>人生は複雑ではない。私達の方が複雑だ。人生は単純で、単純であることが正しいことなのだ</p>
								</div>
							</a>
							<a href="single.html" class="post-meta">いいね  <span class="date-posted">お気に入り保存</span></a>
						</li>
					</ul>	
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 text-center">
					<nav aria-label="Page navigation">
					  <ul class="pagination">
					    <li>
					      <a href="#" aria-label="Previous">
					        <span aria-hidden="true">&laquo;</span>
					      </a>
					    </li>
					    <li class="active"><a href="#">1</a></li>
					    <li><a href="#">2</a></li>
					    <li><a href="#">3</a></li>
					    <li><a href="#">4</a></li>
					    <li><a href="#">5</a></li>
					    <li>
					      <a href="#" aria-label="Next">
					        <span aria-hidden="true">&raquo;</span>
					      </a>
					    </li>
					  </ul>
					</nav>
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
					<!-- <p>
						<ul class="gtco-social-icons">
							<li><a href="#"><i class="icon-twitter"></i></a></li>
							<li><a href="#"><i class="icon-facebook"></i></a></li>
							<li><a href="#"><i class="icon-instagram"></i></a></li>
							<li><a href="#"><i class="icon-info"></i></a></li>
						</ul>
					</p> -->
				</div>
			</div>

		</div>
	</footer>
	</div>

	<!-- ここからモーダルウィンドウ -->
    <div id="modal-content">
      <div id="modal-content-innar">
        <!-- モーダルウィンドウのコンテンツ開始 -->
        <p class="red bold">
          <link href="https://fonts.googleapis.com/css?family=Oxygen:400,300,700" rel="stylesheet" type="text/css"/>
          <link href="https://code.ionicframework.com/ionicons/1.4.1/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
          <div class="signin cf">
            <div class="avatar"></div>

            <form action="" enctype="multipart/form-data" method="post">
	              <div class="inputrow">
	              	<textarea type="text" id="word" name="word" required="required" placeholder="コトバをとどけよう" cols="55" rows="2"></textarea>
	               	<!-- <input type="text" id="name" required="required" placeholder="コトバをとどけよう"/> -->
	              </div>
	              <div class="inputrow">
	              	<textarea type="text" id="explanation" name="explanation" required="required" placeholder="エピソードを教えてください" cols="55" rows="5"></textarea>

	              </div>

			                        <!-- プロフィール写真 -->
			          <div class="form-group">
			            <label class="col-sm-4 control-label"></label>
			            <div class="col-sm-8">
			              <input type="file" name="post_picture" id="post_picture" class="form-control">
<!-- 			              <?php if(isset($error["image"]) && $error["image"]=='type'){ ?>
			              <p class="error">*　画像ファイルを選択してください。</p>
			              <?php } ?> -->
			            </div>
			          </div>

<!--           	<form action="cgi-bin/formmail.cgi" method="post"　name="genre_id" id="genre_id"> -->
<!-- 						<p>ジャンル：<br> -->
								<select name="genre_id" id="genre_id" action="cgi-bin/formmail.cgi">
									<option value="0">過ち</option>
									<option value="1">努力</option>
									<option value="2">人生</option>
									<option value="3">恋愛</option>
									<option value="4">友情</option>
									<option value="5">その他</option>
								</select></p>
<!-- 						</form> -->
		            </form>
		            <input type="submit" value="投稿する" name="ajax" id="ajax"/>
		            <div class="result"></div>
		            <script type="text/javascript">

                    $(function(){
                        $('#ajax').on('click',function(){
                        	    var fd = new FormData();
  														if ($("input[name='post_picture']").val()!== '') {
    													fd.append( "file", $("input[name='post_picture']").prop("files")[0] );
 															}
														  fd.append("word",$('#word').val());
														  fd.append("explanation",$('#explanation').val());
														  fd.append("genre_id",$('#genre_id').val());

														  var postData = {
														    type : "POST",
														    dataType : "text",
														    data : fd,
														    processData : false,
														    contentType : false
														  };
                            // $.ajax({
                            //     url:'post.php',
                            //     type:'POST',
                            //     data:{
                            //         'word':$('#word').val(),
                            //         'explanation':$('#explanation').val(),
                            //         'post_picture':fd,
                            //         'genre_id':$('#genre_id').val()
                            //     }
                            // })
				                              $.ajax("post.php",postData)
				                           .done(function(data){
				                                $('.result').html(data);
				                                console.log(data);
				                            })
				                            .fail(function(data){
				                                $('.result').html(data);
				                                console.log(data);
				                            });
				                        });
				                    });
				            </script>
          </div>
        </p>
        <p><a id="modal-close" class="button-link">閉じる</a></p>
      </div>
     <!-- モーダルウィンドウのコンテンツ終了 -->
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

