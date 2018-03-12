<?php 

  require('function.php');
  login_check();
  require('dbconnect.php');
  require('page.php');
  require('display.php');
  // require('favorite_post.php');

  // foreach ($display_list as $one) {
  //     if($one["member_id"] == $_SESSION["id"]){
  //       $display[]=$one;
  //     }else{
  //     foreach ($follows as $f) 
  //       if ($one["member_id"] == $f["follower_id"]){
  //       $display[]=$one;
  //       }        
  //     }
  // }


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
  <link rel='stylesheet' href='/css/font-awesome-animation.min.css' type='text/css' media='all' />
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
<!--   <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet"> -->
<!--   <link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet"> -->
	</head>
  <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<!--   <script type="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.1.0/font-awesome-animation.css"></script> -->
<!--   <link rel="stylesheet" href="font-awesome-animation.min.css"> -->
	<body>
		
	<div class="gtco-loader"></div>
	
	<div id="page">


  <!-- ナビバー呼び出し -->
  <?php include('nav.php');?>


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
<!-- 				<div class="msg_header">
          <a href="follows.php">Followers<span class="badge badge-pill badge-default"><?php echo $follower["cnt"]; ?></span></a><a href="following.php">Following<span class="badge badge-pill badge-default"><?php echo $following["cnt"]; ?></span></a>
        </div> -->
				<div class="col-md-12">					
					<ul id="gtco-post-list">


          <?php for ($i=1; $i <=30 ; $i++) { 
            foreach($display_list as $post){
             if($post["row"] == $i){?>
                <?php if ($post["size"] == "B") {?>
                              
      						<li class="full entry animate-box" data-animate-effect="fadeIn">
      							<a>
                      <div class="col-lg-6 col-md-12 col-xs-12">
                      <img src="post_picture/<?php echo $post["post_picture"];?>" style="background-size: cover;background-repeat:no-repeat;height:500px;width:100%;vertical-align:top;object-fit: cover;">
                      </div>
                      <br>
      								<div >
      									<h3><?php echo $post["word"]; ?></h3><br>
      									<p><?php echo $post["explanation"]; ?></p>
      								</div>
      							</a>
                    <br><br><br><br><br><br><br><br><br><br><br>
                    <div style="float: right;">
      							<?php if ($post["login_like_flag"] == 0){?>
      							<a href="like.php?like_post_id=<?php echo $post["id"];?>&page=<?php echo $page;?>"><i class="far fa-thumbs-up " aria-hidden="true" style="color: #7f7f7f;font-size: 25px;" ></i></a>
      							<?php }else{?>

      							<a href="like.php?unlike_post_id=<?php echo $post["id"];?>&page=<?php echo $page; ?>"><i class="far fa-thumbs-up " aria-hidden="true" style="color:#DC143C;font-size: 25px;"></i></a>
                    <?php } ?>
                    <?php if($post["like_count"] > 0){echo $post["like_count"];} ?>
      							
                    <?php if($post["login_favorite_flag"] == 0){?>
                    <a href="favorite_function.php?favorite_post_id=<?php echo $post["id"];?>&page=<?php echo $page;?>"><i class="fas fa-heart" aria-hidden="true" style="color: #7f7f7f;font-size: 25px;"></i></a>
                    <?php }else{?>
                    <a href="favorite_function.php?unfavorite_post_id=<?php echo $post["id"];?>&page=<?php echo $page; ?>" ><i class="fas fa-heart" aria-hidden="true" style="color:#DC143C;font-size: 25px;"></i></a>
                    <?php } ;?>

                    <a href="profile.php?member_id=<?php echo $post["member_id"];?>" style="color: #7f7f7f;font-size: 17px;">
                    <?php echo $post["nick_name"]; ?>
                    </a>
                    <?php if(!empty($post["picture_path"])){ ?>
                   <img class="img" src="picture_path/<?php echo $post["picture_path"];?>" style="height:50px;width:50px;color:#7f7f7f;border-radius:50%;object-fit: cover;margin-bottom:25px">
                      <?php }else{ ?>

                    <img class="img" src="picture_path/person-976759_1280.jpg?>" style="height:50px;width:50px;color:#7f7f7f;border-radius:50%;object-fit: cover;margin-bottom:25px">
                      <?php } ?>
                      &nbsp;
                     <?php if($_SESSION["id"] == $post["member_id"]){ ?>
                     <a onclick="return confirm('削除します、よろしいですか？');" href="delete.php?id=<?php echo $post["id"]; ?>" style="color: black;"><i class="far fa-trash-alt" style="font-size: 25px;"></i></a>
                     <?php }?>
                      </div>
      						</li>

              <?php }?>

               <?php if ($post["size"] == "M") {?>
    						<li class="two-third entry animate-box" data-animate-effect="fadeIn"> 
    							<a>
    								<img src="post_picture/<?php echo $post["post_picture"];?>" style="background-size: cover;background-repeat:no-repeat;background-position:50% 50%;object-fit: cover;width:100%;height:340px;">
    								<div class="entry-desc">
    									<h3><?php echo $post["word"]; ?></h3> <br>
    									<p><?php echo $post["explanation"]; ?></p>
    								</div>
    							</a>

                 <div style="float: right;">    
                  <?php if ($post["login_like_flag"] == 0){?>
                  <a href="like.php?like_post_id=<?php echo $post["id"];?>&page=<?php echo $page;?>"><i class="far fa-thumbs-up" aria-hidden="true" style="color: #7f7f7f;font-size: 25px;"></i></a>
                  <?php }else{?>

                  <a href="like.php?unlike_post_id=<?php echo $post["id"];?>&page=<?php echo $page; ?>"><i class="far fa-thumbs-up" aria-hidden="true" style="color:#DC143C;font-size: 25px;"></i></a>
                  <?php } ?>
                  <?php if($post["like_count"] > 0){echo $post["like_count"];} ?>

                  <?php if($post["login_favorite_flag"] == 0){?>
                  <a href="favorite_function.php?favorite_post_id=<?php echo $post["id"];?>&page=<?php echo $page;?>"><i class="fas fa-heart " aria-hidden="true" style="color: #7f7f7f;font-size: 25px;"></i></a>
                  <?php }else{?>
                  <a href="favorite_function.php?unfavorite_post_id=<?php echo $post["id"];?>&page=<?php echo $page; ?>"><i class="fas fa-heart " aria-hidden="true" style="color: #DC143C;font-size: 25px;"></i></a>
                  <?php }?>

<!--               <i class="fas fa-heart " style="color:#DC143C;font-size: 25px;"> -->
               &nbsp;
               <a href="profile.php?member_id=<?php echo $post["member_id"];?>" style="color: #7f7f7f;font-size: 17px;text-align: center;">
               <?php echo $post["nick_name"]; ?> </a>
               <?php if(!empty($post["picture_path"])){ ?>
                <img class="img" src="picture_path/<?php echo $post["picture_path"];?>" style="text-align:right;height:50px;width:50px;color:#7f7f7f;border-radius:50%;object-fit: cover;margin-bottom:25px;">
                <?php }else{ ?>
                <img class="img" src="picture_path/person-976759_1280.jpg?>" style="height:50px;width:50px;color:#7f7f7f;border-radius:50%;object-fit: cover;text-align:right;margin-bottom:25px;">
                <?php } ?>
                &nbsp;
                <?php if($_SESSION["id"] == $post["member_id"]){ ?>
                <a onclick="return confirm('削除します、よろしいですか？');" href="delete.php?id=<?php echo $post["id"]; ?>" style="color: black;"><i class="far fa-trash-alt" style="font-size: 25px;"></i></a>
                <?php }?> 
                </div>     
                </li>
              <?php }


             if ($post["size"] == "SM" || $post["size"] == "S"){?>
						<li class="one-third entry animate-box" data-animate-effect="fadeIn">
              <a>
								<img src="post_picture/<?php echo $post["post_picture"];?>" style="background-size: cover;background-repeat:no-repeat;background-position:50% 50%;width:100%;height:340px;object-fit: cover;">
								<div class="entry-desc">
									<h3><?php echo $post["word"]; ?></h3> <br>
									<p><?php echo $post["explanation"]; ?></p>
								</div>
							</a>
            <div style="float: right;">
              <?php if ($post["login_like_flag"] == 0){?>
              <a href="like.php?like_post_id=<?php echo $post["id"];?>&page=<?php echo $page; ?>" class="post"><i class="far fa-thumbs-up" aria-hidden="true" style="color: #7f7f7f;font-size: 25px;"></i></a>
              <?php }else{?>

              <a href="like.php?unlike_post_id=<?php echo $post["id"];?>&page=<?php echo $page; ?>"><i class="far fa-thumbs-up" aria-hidden="true" style="color:#DC143C;font-size: 25px;"></i></a>
              <?php } ?>
              <?php if($post["like_count"] > 0){echo $post["like_count"];} ?>

              <?php if($post["login_favorite_flag"] == 0){?>
              <a href="favorite_function.php?favorite_post_id=<?php echo $post["id"];?>&page=<?php echo $page;?>"><i class="fas fa-heart" aria-hidden="true" style="color: #7f7f7f;font-size: 25px;"></i></a>
              <?php }else{?>
              <a href="favorite_function.php?unfavorite_post_id=<?php echo $post["id"];?>&page=<?php echo $page; ?>"><i class="fas fa-heart" aria-hidden="true" style="color: #DC143C;font-size: 25px;"></i></a>
              <?php }  ?>

               &nbsp;
              <a href="profile.php?member_id=<?php echo $post["member_id"];?>" style="color: #7f7f7f;font-size: 17px;">
              <?php echo $post["nick_name"]; ?>
              </a>

              <?php if(!empty($post["picture_path"])){ ?>
              <img class="img" src="picture_path/<?php echo $post["picture_path"];?>" style="text-align:center;height:50px;width:50px;color:#7f7f7f;border-radius:50%;object-fit: cover;margin-bottom: 25px;">
              <?php }else{ ?>
              <img class="img" src="picture_path/person-976759_1280.jpg?>" style="height:50px;width:50px;color:#7f7f7f;border-radius:50%;object-fit: cover;margin-bottom:25px;">
              <?php } ?>
              &nbsp;
               <?php if($_SESSION["id"] == $post["member_id"]){ ?>
               <a onclick="return confirm('削除します、よろしいですか？');" href="delete.php?id=<?php echo $post["id"]; ?>" style="color: black;"><i class="far fa-trash-alt" style="font-size: 25px;"></i></a>
               <?php }?>     
            </div>
            </li>
            
            <?php } 
          }
         }
        } 
            
        ?>


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
                  <br><br>

<!--           	<form action="cgi-bin/formmail.cgi" method="post"　name="genre_id" id="genre_id"> -->
<!-- 						<p>ジャンル：<br> -->
<!-- 								<select name="genre_id" id="genre_id" action="cgi-bin/formmail.cgi" style="margin-right: 100px;margin-left: 37px;">
									<option value="0">過ち</option>
									<option value="1">努力</option>
									<option value="2">人生</option>
									<option value="3">恋愛</option>
									<option value="4">友情</option>
									<option value="5">その他</option>
								</select> -->
                <br><br>
                  <div class="col-sm-8">
                   <input type="file" name="post_picture" id="post_picture" class="form-control" style="margin-left: 0px;">
                  </div>
                </p>

                </div>
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

