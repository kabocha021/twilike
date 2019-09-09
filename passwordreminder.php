<?php 
  require('function.php');
  debug('--------------------------------');
  debug('パスワードリセット');
  debug('--------------------------------');
  if(!empty($_POST)){
    debug('POST送信開始');
    
    validEmpty('email',$_POST['email']);

    if(empty($err_msg)){
      debug('空チェッククリア');

      $email = $_POST['email'];
      validEmail($email);
      
      if(empty($err_msg)){
        debug('バリデーションクリア');

        //登録済Emailの場合、再発行用メールを送信する
        if(!emailDuplicate($email)){
          debug('登録ユーザー');

          $reset_key = makeRandKey();
          debug('リセットキー:'.$reset_key);

          // メール送信設定
          $from = sender();
          $to = $email;
          $subject = "【重要なお知らせ】パスワード再発行認証 : ポートフォリオ用サービス";
          $body = <<<EOF
ポートフォリオ用サービスへパスワード再発行依頼がありました。
下記ページへアクセスし、認証キーをご入力後、パスワードがリセットされます。

再発行ページ:http://localhost:8888/PH1/pass_reset.php
認証キー:{$reset_key}
※本認証キーの有効期限は5分です。
EOF;
          sendMail($from,$to,$subject,$body);
          debug('メール送信処理完了');

          //認証に必要な情報をセッションへ保存
          $_SESSION['reset_key'] = $reset_key;
          $_SESSION['reset_email'] = $email;
          $_SESSION['reset_key_limit'] = time()+(60*30); 
          $_SESSION['msg_once'] = SUC03;
          debug(print_r($_SESSION,true));
          
          header("Location:pass_reset.php"); 

        }else{
          debug('未登録ユーザー');
          $err_msg['email'] = ERR11;
        }
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="ja">
  <?php 
  $pageTitle = 'パスワードリマインダー';
  require('head.php');
  require('header.php');
  ?>
  <body>
    <main class="form-width reminder">
      <h1 class="title">パスワードリセット</h1>
      <form method="post">
        <p>パスワードリセットをご希望の場合</p>
        <p>ご登録された<span class="highlight">メールアドレス</span>を入力ください</p>
        <p class="err"><?php showErrMsg('email'); ?></p>
        <input type="text" name="email" class="common-form">

        <div class="submit-box">
          <input type="submit" value="送信する" class="common-form">
        </div>
      </form>      
    </main>

    <?php 
    require('footer.php');
    ?>
  </body>
</html>