<!DOCTYPE html>
<html lang="ja">
  <?php 
  $pageTitle = '`プロフィール編集';
  require('head.php');
  require('header.php');
  ?>
  <body>
    <main class="form-width prof">
      <h1 class="title">ユーザー情報変更</h1>
      <form method="post">
        <span>メールアドレス </span><span class="err">正しいメールアドレスを入力してください</span>
        <input type="text" name="email" class="common-form err">

        <span>ユーザID </span><span class="err"></span>
        <input type="text" name="id" class="common-form">
        
        <span>ひとこと</span>
        <input type="text" name="one-thing" class="common-form">

        <div class="submit-box">
          <input type="submit" value="更新" class="common-form">
        </div>
      </form>      
    </main>

    <?php 
    require('footer.php');
    ?>
  </body>
</html>