<?php 
  require('function.php');
  debug('--------------------------------');
  debug('leave.php');
  debug('--------------------------------');
  if(!auth()) header('location:login.php');

  if(!empty($_POST)){
    debug('POST送信開始');

    // ログインユーザーを退会(delete_flgを1にする)
    try{
      $dbh = createDBH();
      $sql = 'UPDATE USERS SET delete_flg = 1 WHERE user_id = :id AND delete_flg = 0';
      $data = array(':id' => $_SESSION['user_id']);
      $stmt = queryExe($dbh, $sql, $data);

      if($stmt){
        debug('クエリ成功');
        session_destroy();
        header('location:login.php');
      }else{
        debug('クエリ失敗');
        $err_msg['common'] = ERR07;
      }
    }catch (Exception $e){
    error_log('エラー発生:' . $e->getMessage());
    }
  }
?>
<!DOCTYPE html>
<html lang="ja">
  <?php 
  $pageTitle = '退会';
  require('head.php');
  require('header.php');
  ?>
  <body>
    <main class="form-width leave">
      <h1 class="title">退会しますか？</h1>
      <p class="err"><?php showErrMsg('common'); ?></p>
      <form action="" method="post">
        <div class="submit-box">
          <input type="submit" value="はい" name='leave' class="common-form">
        </div>
      </form>      
      <p class="back"><a href="index.php"><i class="fas fa-caret-right" class="link"></i>投稿一覧へ</a></p>
    </main>

    <?php 
    require('footer.php');
    ?>
  </body>
</html>