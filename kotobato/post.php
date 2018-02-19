<?php 
  require('function.php');
  login_check();
  //DBの接続
  require('dbconnect.php');

  if (isset($_POST) && !empty($_POST)){

     if ($_POST["word"] == ""){
      $error["word"] = "blank";
    }
     if ($_POST["explanation"] == ""){
      $error["explanation"] = "blank";
    }

    $word = $_POST['word'];
    $explanation = $_POST['explanation'];
    $genre_id = $_POST['genre_id'];
    $member_id = $_SESSION['id'];

    }

  $redirect_flag = 0;

  //一字ファイルができているか（アップロードされているか）チェック
       // var_dump($_POST); 

       // var_dump($_FILES); 
       // exit;
  if(!isset($error)){
    $ext = substr($_FILES['file']['name'],-3);
    if(($ext == 'png') || ($ext == 'jpg') || ($ext == 'gif')){
      //画像のアップロード処理
      //例）eriko1.pngを指定したとき　$picture_nameの中身は20171222142530eriko1.pngというような文字列が代入される。
      //ファイル名の決定
    $picture_name = date('YmdHis') . $_FILES['file']['name'];

      //アップロード（フォルダに書き込み権限がないと、保存されない！！）
      // アップロードしたいファイル、サーバーのどこにどういう名前でアップロードするか指定
    move_uploaded_file($_FILES['file']['tmp_name'], 'post_picture/'.$picture_name);

    // SESSION変数に入力された値を保存
    // 注意！必ず、ファイルの一番上に、session_strat();と書く
    // POST送信された情報をjoinというキー指定で保存
    $_SESSION['join'] = $_POST;
    $_SESSION['join']['post_picture'] = $picture_name;

    try{
        //DBに会員情報を登録するSQL文を作成
        //now()　　MySQLが用意してくれる関数。現在日時を取得できる。

      $sql = "INSERT INTO `kotobato_posts`(`word`,`explanation`,`post_picture`,`genre_id`,`member_id`,`delete_flag`,`created`,`modified`) VALUES(?,?,?,?,?,0,now(),now())";

      $data = array($word,$explanation,$picture_name,$genre_id,$member_id);
             // var_dump($_POST); 
      $stmt = $dbh->prepare($sql);

      $stmt->execute($data);


        // $sql_pic =  "INSERT INTO `kotobato_posts`(`post_picture`) VALUES (?) ";
        //SQL文実行
        // sha1　暗号化を行う関数
        // $data_pic = array($picture_name);
        // $stmt_pic = $dbh->prepare($sql_pic);
        // $stmt_pic->execute($data_pic);

        //$_SESSIONの情報を削除
        // unset　指定した変数を削除するという意味。SESSIONじゃなくても使える。
        // unset($_SESSION["join"]);

        //thanks.php へ遷移
        // header('Location: thanks.php');
        // exit();

        }catch(Exception $e){
          //tryで囲まれた処理でエラーが発生した時に
          //やりたい処理を記述する場所
          echo 'SQL実行エラー:'.$e->getMessage();
          exit();
        }
    }else{
    $error["image"] = 'type';
    }
  }


if((isset($error["word"])) && ($error["word"]=="blank")){
echo "※コトバを入力してください";
}elseif((isset($error["explanation"])) && ($error["explanation"]=="blank")){
echo "※エピソードを入力してください";
}elseif((isset($error["image"])) && ($error["image"]=='type')){
echo "※画像はpng,jpg,gifから選んでください";
}else{
  //no error
  $redirect_flag = 1;
}
 ?>

 <?php if ($redirect_flag == 1){
 ?>
  <script type="text/javascript">
    // console.log('redirect');
    window.location.href= 'main.php';
  </script>

 <?php } ?>

         <!--          <div class="col-sm-8">
                    <input type="file" name="post_picture" id="post_picture" class="form-control">
                    <?php if(isset($error["image"]) && $error["image"]=='type'){ ?>
                    <p class="error">*　画像ファイルを選択してください。</p>
                    <?php } ?>
                  </div> -->