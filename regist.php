<?php 
  //共通処理の読み込み
  require('function.php');

  debug('--------------------------------');
  debug('regist.php');
  debug('--------------------------------');
  if(auth()){
    debug('ログインユーザのためトップページへ遷移');
    header('location:index.php');
  }
  if(!empty($_POST)){
    debug('POST送信開始');

    $err_msg = array(); 

    debug('バリデーションチェック');
    // 未入力チェック
    validEmpty('email',$_POST['email']);
    validEmpty('name',$_POST['name']);
    validEmpty('pass',$_POST['pass']);
    validEmpty('pass_re',$_POST['pass_re']);

    if(empty($err_msg)){
    debug('未入力チェッククリア');
    
    $email = $_POST['email'];
    $name = $_POST['name'];
    $pass = $_POST['pass'];
    $pass_re = $_POST['pass_re'];
    
    // Email形式チェック
    validEmail($email);
    // Email重複チェック
    emailDuplicate($email);

    // 名前は4文字以上
    validLen('name',$name,4);

    // パスワードは半角英数字のみ、6文字以上
    validHalfwidth('pass',$pass);
    validLen('pass',$pass,4);

    // パスワードとパスワード(再確認)の等価チェック
    validEqual($pass,$pass_re,"pass_re");

    if(empty($err_msg)){
      debug('バリデーションチェッククリア');
      //新規ユーザーを登録
      try{
        $dbh = createDBH();
        $sql = 'INSERT INTO USERS (name, email, pass, avatar, create_date) VALUES (:name, :email, :pass, :avatar, :date)';
        $data = array(
          'name' => $name,
          'email' => $email,
          ':pass' => password_hash($pass,PASSWORD_BCRYPT),
          ':avatar' => 'img/none.png',
          ':date' => date('y-m-d h:i:s'),
        );
        $stmt = queryExe($dbh, $sql, $data);

        if(empty($err_msg)){
          // INSERTでエラーになった場合は、$err_msg['common']にエラーメッセージが入る
          debug('新規ユーザーを登録');
          debug('トップページへ遷移');
  
          // セッションにログイン時刻、有効期限、ユーザIDを設定
          $_SESSION['login_date'] = time();
          $_SESSION['login_limit'] = 60*60;        
          $_SESSION['user_id'] = $dbh->lastInsertID();
          debug('セッション変数:' . print_r($_SESSION,true));
          header('location:index.php');
        }
        
      } catch (Exception $e){
      error_log('エラー発生:' . $e->getMessage());
      }
      
    }


    }else{
    debug('フォーム未入力');
    debug(print_r($err_msg,true));
    }
  }


 ?>

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
      <p class="err">
        <?php showErrMsg('common'); ?>
      </p>
      <form method="post">
        <span>メールアドレス </span>
        <span class="<?php errDetect('email') ?>"><?php showErrMsg('email'); ?></span>
        <input type="text" name="email" class="common-form <?php errDetect('email'); ?>" value="<?php formRemain('email') ?>">

        <span>ユーザ名 </span>
        <span class="<?php errDetect('name') ?>"><?php showErrMsg('name'); ?></span>
        <input type="text" name="name" class="common-form <?php errDetect('name'); ?>" value="<?php formRemain('name') ?>">

        <span>パスワード </span>
        <span class="<?php errDetect('pass') ?>"><?php showErrMsg('pass'); ?></span>
        <p class="text">※半角英数字のみ4文字以上でご入力ください</p>

        <input type="password" name="pass" class="common-form <?php errDetect('pass'); ?>"  value="<?php formRemain('pass'); ?>">
        
        <span>パスワード(再入力) </span>
        <span class="<?php errDetect('pass_re') ?>"><?php showErrMsg('pass_re'); ?></span>
        <input type="password" name="pass_re" class="common-form <?php errDetect('pass_re'); ?>"  value="<?php formRemain('pass_re'); ?>">

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