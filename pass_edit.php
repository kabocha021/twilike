<?php 
  require('function.php');
  debug('--------------------------------');
  debug('pass_edit.php');
  debug('--------------------------------');

  if(!empty($_POST)){
    debug('POST送信開始');
    $err_msg = array();

    validEmpty('pw_old',$_POST['pw_old']);
    validEmpty('pw_new',$_POST['pw_new']);
    validEmpty('pw_new_re',$_POST['pw_new_re']);

    if(empty($err_msg)){
      
      $pw_old = $_POST['pw_old'];
      $pw_new = $_POST['pw_new'];
      $pw_new_re = $_POST['pw_new_re'];

      // 現在パスワードが正しいか
      validPassCheck('pw_old',$pw_old);

      // パスワードは半角英数字のみ、6文字以上
      validHalfwidth('pw_new',$pw_new);
      validLen('pw_new',$pw_new,4);

      // パスワードとパスワード(再確認)の等価チェック
      validEqual($pw_new,$pw_new_re,"pw_new_re");

      // 新旧でパスワードが異なることを確認
      if($pw_old === $pw_new){
        $err_msg['pw_new'] = ERR10;
      }

      if(empty($err_msg)){
        debug('バリデーションチェッククリア');
        
        try{
          $dbh = createDBH();
          $sql = 'UPDATE USERS SET pass = :pass WHERE user_id = :id AND delete_flg = 0';
          $data = array(':id' => $_SESSION['user_id'], ':pass' => password_hash($pw_new, PASSWORD_DEFAULT));

          $stmt = queryExe($dbh, $sql, $data);

          if($stmt){
            debug('パスワード変更完了');
            $_SESSION['msg_once'] = SUC01;
            header('location:index.php');
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
  $pageTitle = 'パスワード変更';
  require('head.php');
  require('header.php');
  ?>
  <body>
    <main class="form-width passedit">
      <h1 class="title">パスワード変更</h1>
      <form method="post">

        <span class="err"><?php showErrMsg('common'); ?></span><br>
        <span>現在のパスワード</span><span class="err"><?php showErrMsg('pw_old'); ?></span>
        <input type="password" name="pw_old" class="common-form <?php errDetect('pw_old') ?>" value="<?php formRemain('pw_old'); ?>">

        <span>新しいパスワード</span><span class="err"><?php showErrMsg('pw_new'); ?></span>
        <input type="password" name="pw_new" class="common-form <?php errDetect('pw_old') ?>" value="<?php formRemain('pw_new'); ?>">

        <span>新しいパスワード(再入力)</span><span class="err"><?php showErrMsg('pw_new_re'); ?></span>
        <input type="password" name="pw_new_re" class="common-form <?php errDetect('pw_old') ?>"  value="<?php formRemain('pw_new_re'); ?>">

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