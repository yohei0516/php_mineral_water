
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
<html lang="ja">
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
  <!-- 検索処理 -->
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
    $sql = "SELECT * FROM `kotobato_posts` WHERE word = :id";

    // プリペアドステートメントを作成
    $stmt = $pdo->prepare($sql);
    // プレースホルダと変数をバインド
    $stmt -> bindParam(":id",$id);
    $stmt -> execute(); //実行

    $search_list = array();
    // 1行ずつ取得
    while($rec = $stmt->fetch(PDO::FETCH_ASSOC)){
        if ($rec == false){
          break;
        }
        $search_list[] = $rec;
    }
      // テーブルの項目名を指定して値を表示
      // echo $rec['id'];
      // echo $rec['word'];
      // echo $rec['explanation'];
      // echo '<br>';
    // }

  }catch (PDOException $e) {
    // UTF8に文字エンコーディングを変換
    echo mb_convert_encoding($e->getMessage(),'UTF-8','SJIS-win');
  }
  // // 接続を閉じる
  // $pdo = null;
?>
  
  <div id="gtco-main">
    <div class="container">

      <?php foreach ($search_list as $tweet) { ?>

      <div class="row row-pb-md">
        <div class="col-md-12">
          <ul id="gtco-post-list">
            <li class="full entry animate-box" data-animate-effect="fadeIn">
              <!-- <a href="images/img_1.jpg"> -->
              <img src="post_picture/<?php echo $tweet["post_picture"]; ?>" >
                <!-- <div class="entry-img" style="background-image: url(images/img_1.jpg"></div> -->
                <div class="entry-desc">
                  <h3> <?php echo $tweet["word"]; ?><!--  世界はいつも、決定的瞬間だ。  --></h3> <br>
                  <p> <?php echo $tweet["explanation"]; ?><!-- 写真っていうのはねぇ。いい被写体が来たっ、て思ってからカメラ向けたらもう遅いんですよ。その場の空気に自分が溶け込めば、二、三秒前に来るのがわかるんですよ。その二、三秒のあいだに絞りと、シャッタースピード、距離なんかを合わせておくんです。それで撮るんですよ。 --></p>
                </div>
              </a>
              <a href="#" class="post-meta">いいね  <span class="date-posted">お気に入り保存</span></a>
            </li>
          </ul> 
        </div>
      </div>

      <?php } ?>

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

