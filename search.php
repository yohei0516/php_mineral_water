<?php
  // セッションスタート
  require('function.php');
  // ログインチェック
  login_check();
  // DBに接続
  require('dbconnect.php');
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
  <link rel="stylesheet" href="css/searched/animate.css">
  <!-- Icomoon Icon Fonts-->
  <link rel="stylesheet" href="css/searched/icomoon.css">
  <!-- Simple Line Icons -->
  <link rel="stylesheet" href="css/searched/simple-line-icons.css">
  <!-- Bootstrap  -->
  <link rel="stylesheet" href="css/searched/bootstrap.css">
  <!-- Magnific Popup -->
  <link rel="stylesheet" href="css/searched/magnific-popup.css">
  <!-- Theme style  -->
  <link rel="stylesheet" href="css/searched/style.css">
  <!-- font-awesome  -->
  <link rel="stylesheet" href="css/searched/font-awesome.min.css" >
  <!-- Modernizr JS -->
  <script src="js/modernizr-2.6.2.min.js"></script>
  <!-- FOR IE9 below -->
  <!--[if lt IE 9]>
  <script src="js/respond.min.js"></script>
  <![endif]-->
  </head>

  <body>
  <div class="gtco-loader"></div>
  
  <div id="page">
 
  <!-- ナビバー呼び出し -->
  <?php include('nav.php');?>

  <?php
  // POSTデータを受け取る
  $id = $_POST['id'];
  // echo "<pre>";
  // var_dump($_POST['id']);
  // echo "</pre>";

  // try-catchです。エラー発生時はcatchのロジックが実行される
  try{
    // データベースへの接続を表すPDOインスタンスを生成
    $pdo = new PDO($dsn, $user, $password);

    // :idは、プレースホルダ
    $sql = "SELECT * FROM `kotobato_posts` WHERE id = :id";

    // プリペアドステートメントを作成
    $stmt = $pdo->prepare($sql);
    // プレースホルダと変数をバインド
    $stmt -> bindParam(":id",$id);
    $stmt -> execute(); //実行

    // 1行ずつ取得
    while($rec = $stmt->fetch(PDO::FETCH_ASSOC)){

      // テーブルの項目名を指定して値を表示
      echo $rec['id'];
      echo $rec['word'];
      echo $rec['explanation'];
      echo '<br>';
    }

  }catch (PDOException $e) {
    // UTF8に文字エンコーディングを変換
    echo mb_convert_encoding($e->getMessage(),'UTF-8','SJIS-win');
  }
  // // 接続を閉じる
  // $pdo = null;
?>
  
<div id="fh5co-blog-section">
  <div class="container">
    <div class="row" >
      <!-- フローティングメニューが入る -->
      <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
      <div class="container" >
        <div class="row">
          <div class="col-xs-12 col-md-7 col-lg-12" style="margin-top:245px;">
            <div class="mypage-heading">
              <h2 style="float:left;">検索結果&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h2>
                <p style="float: left; margin-bottom:26px; padding-top:6px;">日付順
                  <select class="day">
                    <option value="down">降順</option>
                    <option value="up">昇順</option>
                  </select>&nbsp;&nbsp;&nbsp;
                </p>
                <p style="margin-bottom:26px; padding-top:6px;">いいね順
                  <select class="likes">
                    <option value="more">多い順</option>
                    <option value="less">少ない順</option>
                  </select>
                </p> 
            </div>
            <div class="mypage-inner">
              <div class="desc" style="background-color: white;">
                <a href="#"><img class="img-responsive" align="left" src="images/img_1.jpg" alt="mypage" width="200" height="150" style="margin-right: 15px;margin-top: 20px;"></a>
                <br>
                <h3 align="left" style="font-weight: bold;"><?php echo $_rec['word']; ?></h3>
                <p  align="left" style="font-weight: bold;"><?php echo $_rec['explanation']; ?></p>
                <br>
                <p align="right" style="margin-bottom:5px;"><a class="fa fa-leaf" aria-hidden="true" style="color:black"></a><a href="#" align="right" style="color:black;" class="fa fa-star-o" aria-hidden="true"></a></p>
              </div>
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

