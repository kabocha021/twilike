<!DOCTYPE html>
<html lang="ja">
  <?php 
  $pageTitle = 'メニュー';
  require('head.php');
  require('header.php');
  ?>
  <body>
    <main class="form-width menu">
      <h1 class="title">メニュー</h1>
      
      <nav class="nav-menu">
        <ul>
          <li><a href="profedit.php"><i class="fas fa-caret-right" class="link"></i>プロフィール編集</a></li>
          <li><a href="pass_edit.php"><i class="fas fa-caret-right" class="link"></i>パスワードを変更する</a></li>
          <li><a href="leave.php"><i class="fas fa-caret-right" class="link"></i>退会する</a></li>
        </ul>
      </nav>

      <p class="back"><a href="index.php"><i class="fas fa-caret-right" class="link"></i>投稿一覧へ</a></p>
    </main>
    <?php 
    require('footer.php');
    ?>
  </body>
</html>