<?php 
  require('function.php');
  debug('--------------------------------');
  debug('パスワードリセット画面');
  debug('--------------------------------');

  //セッションにリセットキー情報がない場合、リセットキー送信画面へリダイレクト
  if(empty($_SESSION['reset_key'])) header('location:passwordreminder.php');
  debug(print_r($_SESSION,true));

  if(!empty($_POST)){
    debug('POST送信開始');

    $err_msg = array();
    validEmpty('reset_key',$_POST['reset_key']);

    if(empty($err_msg)){
      debug('空チェッククリア');
      
      // 入力されたキーとセッション上のキーが等しいか
      if($_POST['reset_key'] !== $_SESSION['reset_key']) $err_msg['reset_key'] = ERR12;

      // 有効期限内か
      if($_SESSION['reset_key_limit'] < time()) $err_msg['reset_key'] = ERR13;

      if(empty($err_msg)){
        debug('リセット処理開始');

        $pw = makeRandKey();
        $email = $_SESSION['reset_email'];
        debug('パスワード:'.$pw);
        debug('アドレス'.$email);

        try{
          $dbh = createDBH();
          $sql = 'UPDATE USERS SET pass = :pw WHERE email = :email AND delete_flg = 0';
          $data = array(':pw' => password_hash($pw,PASSWORD_BCRYPT), ':email' => $email);
          $stmt = queryExe($dbh, $sql, $data);

          if($stmt){
            debug('パスワード更新完了');

            // メール送信設定
            // 1の時は本番設定
            $from = sender();
            $to = $email;
            $subject = "【重要なお知らせ】パスワード再発行完了 : ポートフォリオ用サービス";
            $body = <<<EOF
パスワードを再発行いたしました。
下記ページからログインを行ってください
ログインページ:http://localhost:8888/PH1/login.php
パスワード:{$pw}
EOF;
            sendMail($from,$to,$subject,$body);
            debug('メール送信処理完了');

            //認証に必要な情報をセッションへ保存
            session_unset();
            $_SESSION['msg_once'] = SUC04;
            header("Location:login.php"); 
          }else{
            debug('クエリ失敗');
            $err_msg['reset_key'] = ERR07;
          }
        } catch (Exception $e){
          error_log('エラー発生:' . $e->getMessage());
       }      
      }
    }
  }
?>
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
        <span class="err"><?php showErrMsg('reset_key'); ?></span>

        <input type="text" name="reset_key" class="common-form">

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