<?php 
  session_start();
  //DBに接続
  require('../dbconnect.php');

  //会員ボタンが押された時
  if (isset($_POST) && !empty($_POST)){
  //変数に入力された値を代入して扱いやすいようにする。
    $nick_name = $_SESSION['join']['nick_name'];
    $email = $_SESSION['join']['email'];
    $password = $_SESSION['join']['password'];

    try{
    //DBに会員情報を登録するSQL文を作成
    //now()　　MySQLが用意してくれる関数。現在日時を取得できる。
      $sql =  "INSERT INTO `kotobato_members`(`nick_name`, `email`, `password`,`created`, `modified`) VALUES (?,?,?,now(),now())";
    //SQL文実行
    // sha1　暗号化を行う関数
      $data = array($nick_name,$email,sha1($password));
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      // var_dump($nick_name);

    //$_SESSIONの情報を削除
    // unset　指定した変数を削除するという意味。SESSIONじゃなくても使える。
      unset($_SESSION["join"]);

      //thanks.php へ遷移
      header('Location: thanks.php');
      exit();

    }catch(Exception $e){
    //tryで囲まれた処理でエラーが発生した時に
    //やりたい処理を記述する場所
      echo 'SQL実行エラー:'.$e->getMessage();
      exit();
    }
  }

 ?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>新規会員登録</title>
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Raleway:700,400">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/join.css">
</head>
<body>
    <div class="form-wrapper">
      <h1>入力内容確認</h1>
      <form method="post" action="" >
      <input type="hidden" name="action" value="submit">
        <div class="form-item">
          <label for="nick_name"></label>
           <?php echo $_SESSION['join']['nick_name']; ?>
        </div>

        <div class="form-item">
          <label for="email"></label>
          <?php echo $_SESSION['join']['email']; ?>
        </div>

        <div class="form-item">
          <label for="password"></label>
          <input type="password" name="password" required="required" value="●●●●●●●●"></input>
        </div>

        <div class="button-panel">
          <input type="submit" class="button" value="完了する"></input>
        </div>
      </form>
      <div class="form-footer">
        <p><a href="join.php?action=rewrite">入力内容を修正する</a></p>
      </div>
    </div>  
</body>
</html>
