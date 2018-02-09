<?php 
  session_start();
//クッキー情報が存在してたら（自動ログイン）
//２回目のログイン時のif文。$_POSTにログイン情報を保存します。
//３回目はスキップされて送信済みのif文を実行する。
  if(isset($_COOKIE["email"]) && !empty($_COOKIE["email"])){
  $_POST["email"] = $_COOKIE["email"];
  $_POST["password"] = $_COOKIE["password"];
  $_POST["save"] = "on";
  }

// var_dump($_POST);

//POST送信されていたら
 require('dbconnect.php');
 if (isset($_POST) && !empty($_POST)){
  //認証処理
  try{
  //メンバーズテーブルでテーブルの中からメールアドレスとパスワードが入力されたものと合致する
  //データを取得
  //暗号化したパスワードを元に戻すのではなく、再度パスワードを暗号化する。
  $sql = "SELECT * FROM `kotobato_members` WHERE `email`=? AND `password`=?";


  //SQL文実行
  //パスワードは、入力されたものを暗号化した上で使用する
  $data = array($_POST["email"],sha1($_POST["password"]));
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);


  //1行取得
  $members = $stmt->fetch(PDO::FETCH_ASSOC);

// var_dump($data);
  // echo "</pre>";
  // var_dump($members);
  // echo "</pre>";


  if($members == false){
    //認証失敗
    $error["login"] = "failed";
  }else{
    //認証成功
    //　１．セッション変数に会員idを保存
    $_SESSION["id"] = $members["id"];

    //２．ログインした時間をセッション変数の保存
    $_SESSION["time"] = time();

    //３．自動ログインの処理
    if($_POST["save"] == "on"){
      //クッキーにログイン情報を記録（保存したい名前、保存したい値、保存したい期間：秒数）
      setcookie('email',$_POST["email"],time()+60*60*24*14);
      setcookie('password',$_POST["password"],time()+60*60*24*14);

    }

    // ４．ログイン後の画面に移動
    header("Location: main.php");
    exit();
  }

  }catch(Exception $e){
     echo 'SQL実行エラー:'.$e->getMessage();
    exit();
  }
}


 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
  <title>ログイン</title>
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Raleway:700,400">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/index/normalize.css">
  <link rel="stylesheet" href="css/index/style.css">
  <link rel="stylesheet" href="css/index/bootstrap.css">
  <!-- モーダルウィンドウ -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="js/login.js"></script>
</head>
<body>

  <header class="header">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
            <p class="site-title-sub">「傷」と「コトバ」をつなげよう。</p>
            <p class="site-title">
              こころに残る体験から生まれたあなたにとって<br>
              大切なコトバはどんなものですか？<br>
              いま傷ついている他の誰かにあなたが救われた<br>
              意味のあるコトバを届けよう。
            </p>
            <div class="buttons">
              <a id="modal-open" class="button button-link">ログイン</a>
              <a class="button button-showy" href="join/join.php">新規登録</a>
            </div>
          <p class="site-description">Kotobatoについてさらに詳しく ></p>
        </div>

        <div class="logo col-lg-6"><img src="images/logo.png"></div>

      </div>
    </div>
  </header>

      <!-- ここからモーダルウィンドウ -->
    <div id="modal-content">
      <div id="modal-content-innar">
        <!-- モーダルウィンドウのコンテンツ開始 -->
        <p class="red bold">
          <link href="https://fonts.googleapis.com/css?family=Oxygen:400,300,700" rel="stylesheet" type="text/css"/>
          <link href="https://code.ionicframework.com/ionicons/1.4.1/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
          <div class="signin cf">
            <div class="avatar"></div>
            <form method="post" action="" class="form-horizontal" role="form">
              <div class="inputrow">
                <input type="email" id="name" class="form-control" placeholder="メールアドレス" name="email"/>
                <label class="ion-person" for="name"></label>
              </div>

              <div class="inputrow">
              <input type="password" id="pass" class="form-control" placeholder="パスワード" name="password"/>
              <label class="ion-locked" for="pass"></label>
              </div>
              <div>
              <?php if((isset($error["login"])) && ($error["login"]=='failed')){ ?>
              <p class="error">※emailかパスワードが間違っています。</p>
              <?php } ?>
              </div>
              <input type="checkbox" name="save" id="remember"/>
              <label class="radio" for="remember">ログイン情報を記憶する</label>
              <input type="submit" value="Login"/>
              </form>
             </div>     
          </div>
        </p>
        <p><a id="modal-close" class="button-link">閉じる</a></p>
     </div>
     <!-- モーダルウィンドウのコンテンツ終了 -->
   </div>
  <script src="lib/placeholders.min.js"></script>
</body>
</html>
