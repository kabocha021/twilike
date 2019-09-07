<?php
  require('function.php');
  debug('--------------------------------');
  debug('index.php');
  debug('--------------------------------');

  if(!auth()){
    // 未ログインユーザーはログイン画面へ遷移
    header('location:login.php');
  }

  // ログインユーザ情報を取得
  $userInfo = getUser($_SESSION['user_id']);
  debug('ログインユーザ情報');
  debug(print_r($userInfo,true));

  // 投稿一覧を取得
  $mesList = getMes(0);
  debug('投稿一覧');
  debug(print_r($mesList,true));

  if(!empty($_POST)){
    debug('POST送信開始');

    $err_msg;
    validEmpty('comment',$_POST['comment']);
    if(empty($err_msg)){
      debug('バリデーションチェッククリア'); 
      $comment = $_POST['comment'];
      // DB登録
      try{
        $dbh = createDBH();
        $sql = 'INSERT INTO COMMENT (user_id, comment, send_date) VALUES (:user_id, :comment, :date)';
        $data = array(
          ':user_id' => $userInfo['user_id'],
          ':comment' => $comment,
          ':date' => date('Y-m-d H:i:s'),
        );
        $stmt = queryExe($dbh, $sql, $data);
        header('location:index.php
        ');
      } catch (Exception $e){
      error_log('エラー発生:' . $e->getMessage());
      }
    }
  }

?>
<!DOCTYPE html>
<html lang="ja">
  <?php 
    $pageTitle = '投稿一覧';
    require('head.php');
  ?>
  <?php debug('セッション情報を表示'); debug(print_r($_SESSION,true)); ?>
   <div id="js-show-msg" class="">
    <?php getSessionMsg('msg_once') ?>
  </div>
  <?php
    require('header.php');
  ?>
  <body>

 
    <main id="main" class="site-width">
      <h2 class="title">投稿一覧</h2>
      <div class="main-column">

      <?php 
        if(!empty($mesList)){
          foreach($mesList as $key => $value):
      ?>
            <div class="conteiner <?php if($value['user_id'] === $_SESSION['user_id']) echo 'mine'; ?>">
              <div class="img-box">
                <img src="img/avator/<?php echo sanitize($value['avatar']); ?>" alt="">
              </div>
              <div class="info-box">
                <p class="head">
                  <span class="name"><?php echo sanitize($value['name']); ?></span>
                  <span class="date"><?php echo $value['send_date']; ?></span>
                </p>
                <p class="comment"><?php echo sanitize($value['comment']); ?></p>
              </div>
            </div>
      <?php endforeach; }else{ ?>
          <p>投稿はまだありません。</p>
       <?php } ?>
  

      </div>
      <div class="side-menu">
        <div class="prof">
          <div class="img-box">
            <img src="img/avator/<?php echo sanitize($userInfo['avatar']); ?>" alt="">            
          </div>
          <div class="prof-info">
            <p class="username"><?php echo sanitize($userInfo['name']); ?></p>
            <p class="mail"><?php echo sanitize($userInfo['email']); ?></p>
            <p class="regist">登録日:<?php echo substr($userInfo['create_date'],0,10); ?></span>
          </div>
        </div>
        <form action="" method="post">
          <textarea name="comment" cols="30" rows="10" class="whisper-text" placeholder="メッセージ"></textarea>
          <p class="js-count">10/140文字</p>
          <label class="img-area">
            ドラッグ&ドロップ
          <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
          <input class="input-img" type="file" name="img">
            <img src="" alt="" class="img-prev">
          </label>
        <input class="send-button" type="submit" value="つぶやく">
      </form>
    </div>
  </main>

    <?php 
      require('footer.php');
    ?>
  </body>
</html>
