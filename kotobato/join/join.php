
<?php  
session_start();  //SESSIONを使うときは絶対に必要

require('../dbconnect.php');

//書き直し処理（check.phpで書き直し、というボタンが押されたとき）
if (isset($_GET['action']) && $_GET['action']  == 'rewrite'){
//書き直すために初期表示する情報を変数に格納

  $nick_name = $_SESSION['join']['nick_name'];
  $email = $_SESSION['join']['email'];
  $password = $_SESSION['join']['password'];

}else{
  // 通常の初期表示
  $nick_name = '';
  $email = '';
  $password = '';
}

// var_dump($_POST);

// POST送信されたとき
// $_POSTという変数が存在している、かつ、$_POSTという変数の中身が空っぽではない時
//empty...中身が空か判定。0,"",null,falseと言うものを全て空っぽと認識する。
  if (isset($_POST) && !empty($_POST)){
    // 入力チェック
    // $error = array();
    // ニックネームが空っぽだったら$errorという、エラーの情報を格納する変数にnick_nameはblankだったというマークを
    // 　保存しておく。
    if($_POST["nick_name"] ==''){
      $error["nick_name"] = 'blank';
    }
    if($_POST["email"] ==''){
      $error["email"] = 'blank';
    }

    if($_POST["email_again"] != $_POST["email"]){
      $error["email_again"] = 'wrong';
    }

    if($_POST["password_again"] != $_POST["password"]){
      $error["password_again"] = 'wrong';
    }


// passwprd
// strlen　文字の長さ（文字数）を数字で表してくれる関数
    if($_POST["password"] ==''){
     $error["password"] = 'blank';
    }
    elseif(strlen($_POST["password"]) < 4){
     $error["password"] = 'length';
    }
 
// var_dump($error);

    // 入力チェック後、エラーが何もなければ、check.phpに移動
// $errorという変数が存在してなかった場合、入力が正常と認識
    if (!isset($error)){

      //emailの重複チェック
      //DBに同じemailの登録があるか確認
      //COUNT() SQL文の関数。ヒットした数を取得。
      //as 別名　取得したデータに別な名前をつけて扱いやすいようにする
      try{
        //検索条件にヒットした件数を取得するSQL文
        $sql = "SELECT COUNT(*) as `cnt` FROM `kotobato_members` WHERE `email` =?";

        //sql文実行;
        $data = array($_POST["email"]);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        //件数取得
        $count = $stmt->fetch(PDO::FETCH_ASSOC);

        if($count['cnt'] > 0){
          //重複エラー
          $error['email'] = "duplicated";

        }

      }catch(Exception $e){

      }

      if(!isset($error)){
      $_SESSION['join'] = $_POST;
      header('Location: check.php');
      exit();

      }
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
     <?php if (isset($_GET['action']) && $_GET['action']  == 'rewrite'){ ?>
     <h1>入力内容を修正</h1>
     <?php }else{ ?>
     <h1>新規アカウント作成</h1></input>
     <?php } ?>
      <form method="post" action="" class="form-horizontal" role="form" enctype="multipart/form-data">
        <div class="form-item">
          <label for="nick_name"></label> 
          <input type="text" name="nick_name"  placeholder="ニックネーム" value="<?php echo $nick_name; ?>"></input>
          <?php if((isset($error["nick_name"])) && ($error["nick_name"]=='blank')){ ?>
          <p class="error" style="color: red;">※ニックネームを入力してください。</p>
          <?php } ?>
        </div>

        <div class="form-item">
          <label for="email"></label>
          <input type="email" name="email" required="required" placeholder="メールアドレス" value="<?php echo $email; ?>"></input>
          <?php if(isset($error["email"]) && $error["email"]=='duplicated'){ ?>
          <p class="error" style="color: red;">※入力されたEmailは登録済みです。</p>
          <?php } ?>
        </div>

        <div class="form-item">
          <label for="email_again"></label>
          <input type="email_again" name="email_again" required="required" placeholder="(メールアドレスを再入力)"></input>
          <?php if(isset($error["email_again"]) && $error["email_again"] == 'wrong'){ ?>
          <p class="error" style="color: red;">※メールアドレスが一致しません。</p>
          <?php } ?>
        </div>

        <div class="form-item">
          <label for="password"></label>
          <input type="password" name="password" required="required" placeholder="パスワード" value="<?php echo $password; ?>"></input>
        <?php if(isset($error["password"]) && $error["password"]=='blank'){ ?>
        <p class="error" style="color: red;">*　パスワードを入力してください。</p>
        <?php }elseif(isset($error["password"]) && $error["password"]=='length'){?>
        <p class="error" style="color: red;">※パスワードは４文字以上を入力してください。</p>
        <?php } ?>

        </div>

        <div class="form-item">
          <label for="password_again"></label>
          <input type="password_again" name="password_again" required="required" placeholder="(パスワード再入力)"></input>
        <?php if(isset($error["password_again"]) && $error["password_again"] == 'wrong'){ ?>
        <p class="error" style="color: red;">※パスワードが一致しません。</p>
        <?php } ?>
        </div>


        <div class="button-panel">
          <input type="submit" class="button" value="登録する"></input>
        </div>
      </form>
      <div class="form-footer">
        <p><a href="../index.html">トップへ戻る</a></p>
      </div>
    </div>  
</body>
</html>
