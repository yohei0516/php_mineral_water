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
      <h1>入力内容を修正</h1>
      <form action="check.html">
        <div class="form-item">
          <label for="nick_name"></label> 
          <input type="nick_name" name="nick_name"  placeholder="なおき"></input>
        </div>

        <div class="form-item">
          <label for="email"></label>
          <input type="email" name="email" required="required" placeholder="naoki@gmail.com"></input>
        </div>

        <div class="form-item">
          <label for="email"></label>
          <input type="email" name="email" required="required" placeholder="(メールアドレスを再入力)"></input>
        </div>

        <div class="form-item">
          <label for="password"></label>
          <input type="password" name="password" required="required" placeholder="●●●●●●●●"></input>
        </div>

        <div class="form-item">
          <label for="password"></label>
          <input type="password" name="password" required="required" placeholder="(パスワード再入力)"></input>
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
