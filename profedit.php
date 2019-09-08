<?php 
  require('function.php');
  debug('--------------------------------');
  debug('プロフィール編集');
  debug('--------------------------------');
  
   if(!auth()){
    // 未ログインユーザーはログイン画面へ遷移
    header('location:login.php');
  }
  // ログインユーザ情報を取得
  $userInfo = getUser($_SESSION['user_id']);
  debug('ログインユーザ情報');
  debug('');
  debug('FILES情報');
  debug(print_r($userInfo,true));

  $avatar = (empty($_FILES['avatar']['name'])) ? $userInfo['avatar'] : uploadAvatar($_FILES['avatar'],'avatar');
  debug('--------------------------------');
  debug('$userInfo[avatart] =' .$userInfo['avatar'] );
  debug('$avatar =' .$avatar);
  debug('--------------------------------');

  if(!empty($_POST)){
    debug('POST送信開始');
    debug('POST:' . print_r($_POST,true));
    debug('FILE:' . print_r($_FILES,true));

    $err_msg;
    
    validEmpty('email',$_POST['email']);
    validEmpty('name',$_POST['name']);

    if(empty($err_msg)){
      debug('空チェッククリア');
      $email = $_POST['email'];
      $name = $_POST['name'];

      validEmail($email);

      if(empty($err_msg)){
        debug('バリデーションチェッククリア');
        debug($avatar);
        debug($userInfo['avatar']);
        if($email !== $userInfo['email'] || $name !== $userInfo['name'] || $avatar !== $userInfo['avatar']){
          debug('クエリ開始');
          $dbh = createDBH();
          $sql = 'UPDATE USERS SET name = :name, email = :email,avatar = :avatar WHERE user_id = :id AND delete_flg = 0';
          $data = array(':name' => $name, ':email' => $email, ':id' => $_SESSION['user_id'], ':avatar' => $avatar);
          $stmt = queryExe($dbh, $sql, $data);
          if($stmt){
            debug('更新完了');
            $_SESSION['msg_once'] = SUC02;
          }else{
            debug('クエリ失敗');
            $err_msg['common'] = ERR07;
          }
        }else{
          debug('email,ユーザ名に変更がないため、更新の必要無し');
        }
      }
    }
  }
 ?>

<!DOCTYPE html>
<html lang="ja">
  <?php 
  $pageTitle = '`プロフィール編集';
  require('head.php');
  require('header.php');
  ?>
  <body>
    <main class="form-width prof">
      <h1 class="title">ユーザー情報変更</h1>
      <form method="post" enctype="multipart/form-data">
        <!-- リアルタイムプレビュー -->
        <label class="img-label">
          <div class="img-area">
            <p>ドラッグ&ドロップ</p>
            <input type="hidden" name="MAX_FILE_SIZE" value="10485760">
            <input type="file" name="avatar" class="input-file">
            <img src="<?php echoStr($avatar); ?>" alt="" class="avatar-img">
            <!-- <img src="img/avator/defult4.jpg" alt="" class="avatar-img"> -->
          </div>
          <div class="desc">
            <p class="err"><?php showErrMsg('avatar'); ?></p>
            <p>プロフィール画像画像</p>
            <p>※最大10MBまで</p>
          </div>
        </label>

        <span>メールアドレス </span><span class="err"><?php showErrMsg('email'); ?></span>
        <input type="text" name="email" class="common-form <?php errDetect('email'); ?>" value="<?php 
        if(isset($_POST['email'])) echo sanitize($_POST['email']); 
        else echoStr($userInfo['email']);
        ?>">
        <span>ユーザ名 </span><span class="err"><?php showErrMsg('name'); ?></span>
        <input type="text" name="name" class="common-form <?php errDetect('name'); ?>" value="<?php 
        if(isset($_POST['name'])) echo sanitize($_POST['name']); 
        else echoStr($userInfo['name']);
        ?>">
        <!-- <span>ひとこと</span>
        <input type="text" name="one-thing" class="common-form"> -->
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