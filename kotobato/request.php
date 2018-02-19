<?php 
session_start();
header('Content-type: text/plain; charset= UTF-8');

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

// var_dump($_POST);
  // echo "</pre>";
  // var_dump($members);
  // echo "</pre>";

$redirect_flag = 0;
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

  }

  }catch(Exception $e){
     echo 'SQL実行エラー:'.$e->getMessage();
    exit();
  }
}

if((isset($error["login"])) && ($error["login"]=='failed')){
echo "※emailかパスワードが間違っています。";

}else{
  //no error
  $redirect_flag = 1;
}

 ?>

<?php if ($redirect_flag == 1) { ?>

  <script type="text/javascript">
    // console.log('redirect');
    window.location.href= 'main.php';
  </script>
 
<?php } ?>
