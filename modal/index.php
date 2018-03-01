
<?php
  session_start();

// DBに接続
  require('dbconnect.php');

  // 会員ボタンが押されたとき
    if (isset($_POST) && !empty($_POST)) {
      // 変数に入力された値を代入して扱いやすいようにする
      $nick_name = $_POST['nick_name'];
      $email = $_POST['email'];
      $password = $_POST['password'];

      try {
  // DBに会員情報を登録するSQL文を作成
  // now() MYSQLが用意している関数。現在日時を取得できる
        $sql = "INSERT INTO `whereis_members` (`nick_name`, `email`, `password`, `created`, `modified`) VALUES (?,?,?,now(),now()) ";

  // SQL文実行
  // sha1 暗号化を行う関数
        $data = array($nick_name,$email,sha1($password));
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

  // $_SESSIONの情報を削除
  // // unset 指定した変数を削除するという意味。SESSIONじゃなくても使える
  //       unset($_POST["join"]);

  // ログインページへ遷移
       header('Location: post.html');
        exit();


      } catch (Exception $e) {
        // tryで囲まれた処理でエラーが発生したときにやりたい処理を記述
        
        echo 'SQL実行エラー:' . $e->getMessage();
        exit();

      }
    }

?>
















<?php

//クッキー情報が存在してたら（自動ログイン）
// $_POSTにログイン情報を保存します
if (isset($_COOKIE["email"]) && !empty($_COOKIE["email"])){
  $_POST["login_email"] = $_COOKIE["email"];
  $_POST["login_password"] = $_COOKIE["password"];
  $_POST["save"] = "on";

}

//DBに接続
require('dbconnect.php');

// POST送信されていたら
if (isset($_POST) && !empty($_POST)){
  // 認証処理
  try {
    //メンバーズテーブルでテーブルの中からメールアドレスとパスワードが入力されたものと合致する
    // データを取得
    $login_sql = "SELECT * FROM `whereis_members` WHERE `email`=? AND `password`=?";

    //SQL文実行
    // パスワードは、入力されたものを暗号化した上で使用する
    $login_data = array($_POST["login_email"],sha1($_POST["login_password"]));
    $login_stmt = $dbh->prepare($login_sql);
    $login_stmt->execute($login_data);

    //1行取得
    $member = $login_stmt->fetch(PDO::FETCH_ASSOC);
    // echo "<pre>";
    var_dump($member);
    var_dump($login_sql);
    // echo "</pre>";
    
    if ($member == false){
      // 認証失敗
      $error["login"] = "failed";
    }else{
      // 認証成功
      // 1.セッション変数に、会員のidを保存
      $_POST["id"] = $member["member_id"];

      // 2.ログインした時間をセッション変数の保存
      $_POST["time"] = time();

      // // 3.自動ログインの処理
      // if ($_POST["save"] == "on"){
      //   //クッキーにログイン情報を記録
      //   // setcookie(保存したい名前,保存したい値,保存したい期間：秒数)
      //   setcookie('email',$_POST["email"], time()+60*60*24*14);
      //   setcookie('password',$_POST["password"], time()+60*60*24*14);

      // }

      // 4.ログイン後の画面に移動
      // header("Location: post.html");
      exit();
    }

  } catch (Exception $e) {
    
  }


}

?>


<html>

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Where is *(アスタリスク)</title>
    <meta name="Nova theme" content="width=device-width, initial-scale=1">
    

<!--
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
-->
          
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="css/responsive.css"/>
     <link rel="stylesheet" href="css/login.css"/>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- Ryo added -->
<!-- <script type="text/javascript" src="assets/js/jquery-1.7.2.min.js"></script> -->
<!-- <script type="text/javascript" src="assets/js/jquery.ba-hashchange.min.js"></script>
<script type="text/javascript" src="assets/js/autoConfirm.js"></script> -->
</head>


<body>

<!-- Navigation
    ================================================== -->

<div class="hero-background">
   <div>
      <img class="strips" src="earth.png">
   </div>
      <div class="container">
        <div class="header-container header">


                      <div class="header-right">
                <a class="navbar-item" href="contact.html">Contact</a>
            </div>

            
        </div>
        <!--navigation-->

        <!-- Hero-Section
          ================================================== -->
      <form method="POST" action="" >

        <div class="hero row">
            <div class="hero-right col-sm-6 col-sm-6">
                <h1 class="header-headline bold"> 世界の景色をお手軽に <br></h1>
                <h4 class="header-running-text light"> You can see so easy
                the view of the world. </h4>
               

            <button class="hero-btn" > Enter</button>
                
            </div>
<!--                    <button class="hero-btn" id="popup" onclick="div_show()"> Enter</button>-->
<!--                     <button class="hero-btn" > Enter</button> -->
                
<!--             </div><!--hero-left--> 

            <div class="col-sm-6 col-sm-6 ">
                  <div class="loginpanel">
                  <div class="txt">
                  <input id="user6" type="text" placeholder="E-mail" name=login_email />
                  <label for="user" class="entypo-mail"></label>
                  </div>
                      <div class="txt">
                        <input id="pwd7" type="password" placeholder="Password" name=login_password />
                          <label for="pwd" class="entypo-lock"></label>
                      </div>
  
                  <div class="buttons">
                    <input type="submit" value="Login" />
                    <span>
                    <a href="javascript:void(0)" class="entypo-user-add" > Register</a>
                    </span>
                  </div>
  
                  <a href="json_map.html" class="submit_button">
                  <input type="button" value="Visitor" class="submit_button">
                  </a>

<div id="forget_pw">
  <p>passwordを忘れた方は<a href="#">こちら</a></p>
  </div>
  
  <div class="hr">
    <div></div>
    <div>OR</div>
    <div></div>
  </div>
  
  <div class="social">
    <a href="javascript:void(0)" class="facebook"></a>
    <a href="javascript:void(0)" class="twitter"></a>
    <a href="javascript:void(0)" class="googleplus"></a>
  </div>
</div>
           
            </div>

           
        
<div class="col-sm-6 col-sm-6">

    <div class="kaiintouroku">
        <font size="3" color="black">
            <u>
            <strong><div align="center"><p>新規会員登録</p></div></strong>
            </u></font>
        <div class="txt">
            <input id="user" type="text" placeholder="NickName" />
            <label for="user" class="entypo-user-add"></label>
          <?php if((isset($error["login"])) && ($error["login"]== 'failed')){ ?>
              <p class="error">* emailかパスワードが間違っています。</p>
          <?php } ?>
        </div>

        <div class="txt">
            <input id="user1" type="text" placeholder="E-mail" />
            <label for="user" class="entypo-mail"></label>
        </div>


        <div class="txt">
            <input id="user2" type="text" placeholder="Check E-mail Address" />
            <label for="user" class="entypo-mail"></label>
        </div>


        <div class="txt">
            <input id="pwd1" type="password" placeholder="Password" />
            <label for="pwd" class="entypo-lock"></label>
        </div>

        <div class="txt">
            <input id="pwd2" type="password" placeholder="Check Password" />
            <label for="pwd" class="entypo-lock"></label>
        </div>

        <div class="txt">
        </div>

        <div class="buttons">
            <!--      <a href="join/index.php"> -->
            <input type="button" class="hero-btn2" value="Confirm Account" >

        </div>

        <!--hero-->

    </div>
    <!--hero-container-->
</div>


<div class="col-sm-6 col-sm-6">


    <div class="kaiintouroku2">
        <font size="3" color="black">
        <u>
        <strong><div align="center"><p>会員登録確認</p></div></strong>
        </u></font>
        <div class="txt">
            <input id="nick_name" type="text" placeholder="NickName" name="nick_name" readonly />
            <label for="user" class="entypo-user-add"></label>
        </div>

        <div class="txt">
            <input id="email" type="text" placeholder="E-mail" name="email" readonly/>
            <label for="user" class="entypo-mail"></label>
        </div>

        <div class="txt">
            <input id="password" type="password" placeholder="Password" name="password" readonly/>
            <label for="pwd" class="entypo-lock"></label>
        </div>
<!--         <div class="buttons"> -->
            <input type="submit" class="hero-btn2" value="Create Account"  />

    </div>



    </div>           
            <!--hero-background-->
      </form>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
        
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script src="js/login.js"></script>
<script src="js/script.js"></script>

</body>

</html>