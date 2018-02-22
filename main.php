<?php 

  require('function.php');
  login_check();
  require('dbconnect.php');
  require('page.php');
  require('display.php');

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

          <?php for ($i=1; $i <=6 ; $i++) { 
            foreach($display_list as $post){
             if($post["row"] == $i){
              if ($post["size"] == "B") {?>
                              
      						<li class="full entry animate-box" data-animate-effect="fadeIn">
      							<a href="picture_path/<?php echo $post["post_picture"];?>">
      								<div class="entry-img" style="background-image: url(images/img_1.jpg"></div>
      								<div class="entry-desc">
      									<h3><?php echo $post["word"]; ?></h3><br>

      									<p><?php echo $post["explanation"]; ?></p>
      								</div>
      							</a>

      							<a href="profile.php?member_id=<?php echo $post["member_id"];?>"><br>
      		          <?php echo $post["nick_name"]; ?>
      		          </a>

      							<?php if ($post["login_like_flag"] == 0){?>
      							<a href="like.php?like_post_id=<?php echo $post["id"];?>&page=<?php echo $page; ?>" class="post-meta">いいね</a>
      							<?php }else{?>

      							<a href="like.php?unlike_post_id=<?php echo $post["id"];?>&page=<?php echo $page; ?>">だめだね</a>
                    <?php } ?>
                    <?php if($post["like_count"] > 0){echo $post["like_count"];} ?>
      							<span class="date-posted">お気に入り保存</span>
      						</li>

              <?php }

              if ($post["size"] == "M") {?>

    						<li class="two-third entry animate-box" data-animate-effect="fadeIn"> 
    							<a href="picture_path/<?php echo $post["post_picture"];?>">
    								<div class="entry-img" style="background-image: url(images/img_2.jpg"></div>
    								<div class="entry-desc">
    									<h3><?php echo $post["word"]; ?></h3> <br>
    									<p><?php echo $post["explanation"]; ?></p>
    								</div>
    							</a>

                  <a href="profile.php?member_id=<?php echo $post["member_id"];?>"><br>
                  <?php echo $post["nick_name"]; ?>
                  </a>             

                  <?php if ($post["login_like_flag"] == 0){?>
                  <a href="like.php?like_post_id=<?php echo $post["id"];?>&page=<?php echo $page; ?>" class="post-meta">いいね</a>
                  <?php }else{?>

                <a href="like.php?unlike_post_id=<?php echo $post["id"];?>&page=<?php echo $page; ?>">だめだね</a>
                  <?php } ?>
                  <?php if($post["like_count"] > 0){echo $post["like_count"];} ?>
                  <span class="date-posted">お気に入り保存</span>
    						</li>
              <?php }
            
             if ($post["size"] == "SM" || $post["size"] == "S"){?>
            
						<li class="one-third entry animate-box" data-animate-effect="fadeIn">
              <a href="picture_path/<?php echo $post["post_picture"];?>">
								<div class="entry-img" style="background-image: url(images/img_3.jpg"></div>
								<div class="entry-desc">
									<h3><?php echo $post["word"]; ?></h3> <br>
									<p><?php echo $post["explanation"]; ?></p>
								</div>
							</a>

              <a href="profile.php?member_id=<?php echo $post["member_id"];?>"><br>
              <?php echo $post["nick_name"]; ?>
              </a>

              <?php if ($post["login_like_flag"] == 0){?>
              <a href="like.php?like_post_id=<?php echo $post["id"];?>&page=<?php echo $page; ?>" class="post-meta">いいね</a>
              <?php }else{?>

            <a href="like.php?unlike_post_id=<?php echo $post["id"];?>&page=<?php echo $page; ?>">だめだね</a>
              <?php } ?>
              <?php if($post["like_count"] > 0){echo $post["like_count"];} ?>
              <span class="date-posted">お気に入り保存</span>
            </li>
            <?php } 
          }
         }
        } ?>


			<div class="row">
				<div class="col-md-12 text-center">
					<nav aria-label="Page navigation">
					  <ul class="pagination">

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

