<!DOCTYPE html>
<html lang="ja">
  <?php 
  $pageTitle = 'ログイン';
  require('head.php');
  require('header.php');
  ?>
  <body>
    <main class="form-width login">
      <h1 class="title">ログイン</h1>
      <p class="err">メールアドレス又はパスワードが間違っています</p>
      <form method="post">
        <span>メールアドレス </span><span class="err">入力必須です!</span>
        <input type="text" name="email" class="common-form err">

        <span>パスワード </span><span class="err"></span>
        <input type="password" name="pass" class="common-form">

        <div class="submit-box">
          <input type="submit" value="ログインする" class="common-form">
        </div>
      </form>      
      <a href="regist.php" class="link"><i class="fas fa-caret-right"></i> 新規登録はこちら</a>
      <a href="passwordreminder.php"><i class="fas fa-caret-right" class="link"></i> パスワードをリセット</a>
    </main>

    <?php 
    require('footer.php');
    ?>
  </body>
</html>