<?php 
  // 共通関数のよみこみ
  require('function.php');
  
  // セッション情報を出力
  showSession();

  // ログイン認証(ログイン済みの場合はトップページへ)
  if(auth()) header('location:index.php');   
  
  if(!empty($_POST)){
    debug('POST送信開始');

    //バリデーションチェック
    $err_msg = array();

    debug('バリデーションチェック開始');
    validEmpty('email',$_POST['email']);
    validEmpty('pass',$_POST['pass']);

    if(empty($err_msg)){
      debug('未入力チェッククリア');

      $email = $_POST['email'];
      $pass = $_POST['pass'];
      $login_hold = empty($_POST['login_hold']) ? false : true;
      debug('ログイン保持チェック:' . $login_hold);

      validEmail($email);

      if(empty($err_msg)){
        debug('バリデーションチェッククリア');

        // メールアドレスとパスワードで認証
        try{
          $dbh = createDBH();
          $sql = 'SELECT pass,user_id FROM USERS WHERE email = :email AND delete_flg = 0';
          $data = array(':email' => $email);
          $stmt = queryExe($dbh, $sql, $data);

          $result = $stmt->fetch(PDO::FETCH_ASSOC);

          if(password_verify($pass,$result['pass'])){
            debug('パスワード一致');
            debug('SQL実行結果:' .print_r($result,true));

            // ログインする
            $_SESSION['login_date'] = time();
            $_SESSION['user_id'] = $result['user_id'];
            $_SESSION['login_limit'] = $login_hold ? 60*60*24*30 : 60*60;
            
            debug('セッション情報' . print_r($_SESSION,true));
            debug('トップ画面へ繊維');
            header('location:index.php');

          }else{
            debug('Email or Passの不一致');
            $err_msg['common'] = ERR09;
          }
        }catch (Exception $e){
        error_log('エラー発生:' . $e->getMessage());
        }
      }
    }

  }
  
?>

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
      <p class="err"><?php showErrMsg('common'); ?></p>
      <form method="post">
        <span>メールアドレス </span><span class="err"><?php showErrMsg('email'); ?></span>
        <input type="text" name="email" class="common-form <?php errDetect('email'); ?>"  value="<?php formRemain('email'); ?>">

        <span>パスワード </span><span class="<?php errDetect('pass'); ?>"><?php showErrMsg('pass'); ?></span>
        <input type="password" name="pass" class="common-form <?php errDetect('pass'); ?>" value="<?php formRemain('pass'); ?>">

        <label class="test">
          <input type="checkbox" name="login_hold" <?php if(!empty($_POST['login_hold'])):?> checked="checked" 
          <?php endif; ?>>次回ログインを省略する
        </label>

        <div class="submit-box">
          <input type="submit" value="ログイン" class="common-form">
        </div>
      </form>      
      <a href="regist.php" class="link"><i class="fas fa-caret-right"></i>新規登録はこちら</a>
      <a href="passwordreminder.php"><i class="fas fa-caret-right" class="link"></i>パスワードをリセット</a>
    </main>

    <?php 
    require('footer.php');
    ?>
  </body>
</html>