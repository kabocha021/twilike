<header class="header">
  <div class="site-width">
    <h1 class="title"><a href="index.php">パクッター</a></h1>
    <nav class="top-nav">
      <ul>
        <?php if(empty($_SESSION['user_id'])){ ?>
          <li><a class="btn" href="login.php">ログイン</a></li>
        <li><a class="btn primary" href="regist.php">新規登録</a></li>
        <?php }else{ ?>
        <li><a class="btn" href="logout.php">ログアウト</a></li>
        <?php } ?>
      </ul>
    </nav>
  </div>
</header>