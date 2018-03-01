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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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
            <form method="post" action="" class="form-horizontal" role="form" id="form_modal" accept-charset="utf-8" return false>

              <div class="inputrow">
                <input type="text" id="email" class="form-control" placeholder="メールアドレス" name="email"/>
                <label class="ion-person" for="name"></label>
              </div>

              <div class="inputrow">
              <input type="password" id="password" class="form-control" placeholder="パスワード" name="password"/>
              <label class="ion-locked" for="password"></label>
              </div>
              
              <input type="checkbox" name="save" id="remember"/>
              <label class="radio" for="remember" name="">ログイン情報を記憶する</label>
              </form>

              <input type="submit" value="Login" id="ajax"/>
               <div class="result"></div>
                <script type="text/javascript">

                    $(function(){
                        //submitしたときの挙動
                        // $('#modal-content').on('submit',function(e){
                        //     e.preventDefault();
                            //Loginが押されたら
                            // $.ajax({
                            //     url:'request.php',
                            //     type:'POST',
                            //     data:{
                            //         'email':$('#email').val(),
                            //         'password':$('#password').val(),
                            //         'save':$('#remember').val()
                            //     }
                            // })
                            // // .done(function(data){
                            //     $('.result').html(data);
                            //     console.log(data);
                            // })
                            // .fail(function(){
                            //     $('.result').html(data);
                            //     console.log(data);
                            // });
                        // });

                        $('#ajax').on('click',function(){
                            $.ajax({
                                url:'request.php',
                                type:'POST',
                                data:{
                                    'email':$('#email').val(),
                                    'password':$('#password').val(),
                                    'save':$('#remember').val()
                                }
                            })
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
          </div>
        </p>
        <p><a id="modal-close" class="button-link">閉じる</a></p>
     </div>
     <!-- モーダルウィンドウのコンテンツ終了 -->
   </div>
  <script src="lib/placeholders.min.js"></script>
</body>
</html>
