<!DOCTYPE html>
<html lang="ja">
  <?php 
  $pageTitle = 'パスワード変更';
  require('head.php');
  require('header.php');
  ?>
  <body>
    <main class="form-width passedit">
      <h1 class="title">パスワード変更</h1>
      <form method="post">

        <span class="err">現在のパスワードが間違っています<br></span><br>
        <span>現在のパスワード</span>
        <input type="text" name="pw_old" class="common-form">
        <span>新しいパスワード</span>
        <input type="text" name="pw_old" class="common-form">
        <span>新しいパスワード(再入力)</span>
        <input type="text" name="pw_old" class="common-form">

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