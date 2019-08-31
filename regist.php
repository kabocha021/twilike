<!DOCTYPE html>
<html lang="ja">
  <?php 
  $pageTitle = '`ユーザ登録';
  require('head.php');
  require('header.php');
  ?>
  <body>
    <main class="form-width regist">
      <h1 class="title">新規登録</h1>
      <form method="post">
        <span>メールアドレス </span><span class="err">入力必須です!</span>
        <input type="text" name="email" class="common-form err">

        <span>パスワード </span><span class="err"></span>
        <input type="password" name="pass" class="common-form">
        
        <span>パスワード(再入力) </span><span class="err"></span>
        <input type="password" name="pass" class="common-form">

        <div class="submit-box">
          <input type="submit" value="登録" class="common-form">
        </div>
      </form>      
    </main>

    <?php 
    require('footer.php');
    ?>
  </body>
</html>