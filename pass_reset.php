<!DOCTYPE html>
<html lang="ja">
  <?php 
  $pageTitle = 'パスワードリセット';
  require('head.php');
  require('header.php');
  ?>
  <body>
    <main class="form-width reminder">
      <h1 class="title">パスワードリセット</h1>
      <form method="post">
        <span>パスワードリセットをご希望の場合、<br>
        認証キーをご入力ください<br>
        </span><br>
        <span class="err">有効期限切れです</span>

        <input type="text" name="ath_key" class="common-form">

        <div class="submit-box">
          <input type="submit" value="送信" class="common-form">
        </div>

        
      </form>      
    </main>

    <?php 
    require('footer.php');
    ?>
  </body>
</html>