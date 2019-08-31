<!DOCTYPE html>
<html lang="ja">
  <?php 
  $pageTitle = 'パスワードリマインダー';
  require('head.php');
  require('header.php');
  ?>
  <body>
    <main class="form-width reminder">
      <h1 class="title">パスワードリセット</h1>
      <form method="post">
        <span>パスワードリセットをご希望の場合<br>
        ご登録された</span><span class="highlight">メールアドレスを入力ください<br>
        <!-- </span><span class="err">正しいメールアドレスを入力してください</span> -->
        <input type="text" name="email" class="common-form">

        <div class="submit-box">
          <input type="submit" value="送信する" class="common-form">
        </div>
      </form>      
    </main>

    <?php 
    require('footer.php');
    ?>
  </body>
</html>