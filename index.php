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

  // GETパラメータで表示を制御
  $search = (empty($_GET['search'])) ? '' : $_GET['search'];
  if(isset($_GET['sort'])) $sort = ($_GET['sort'] === '2') ? 1 : 0;
    else $sort = 0;
  debug('検索値:' .$search);
  debug('並び順:'.$sort);

  // 投稿一覧を取得
  $mesList = getMes($search,$sort);
  debug('投稿一覧');
  // debug(print_r($mesList,true));

  // 投稿された場合
  if(isset($_POST['whisper'])){
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
  <?php
    require('header.php');
  ?>
  <body>

 
    <main id="main" class="site-width">
      <div class="main-column">
      <h2 class="title">投稿一覧</h2>
      <?php 
        if(!empty($mesList)){
          foreach($mesList as $key => $value):
            // debug(print_r($value,true));
      ?>
            <div class="conteiner <?php if($value['user_id'] === $_SESSION['user_id']) echo 'mine'; ?>">
              <div class="img-box">
                <img src="<?php echo sanitize($value['avatar']); ?>" alt="">
              </div>
              <div class="info-box">
                <p class="head">
                  <!-- ユーザネーム -->
                  <span class="name"><?php echo sanitize($value['name']); ?></span>
                  <!-- 投稿時刻 -->
                  <span class="date"><?php echo $value['send_date']; ?></span>
                  <!-- お気に入り追加機能 -->
                  <i class="fas fa-star fav js-fav <?php if(getFavFlg($_SESSION['user_id'],$value['comment_id']) === 1) echo 'active'; ?>" data-id="<?php  echo $value['comment_id']; ?>"></i>

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
        <h2 class="title">プロフィール</h2>
          <div class="img-box">
            <img src="<?php echo sanitize($userInfo['avatar']); ?>" alt="">            
          </div>
          <div class="prof-info">
            <p class="username"><?php echo sanitize($userInfo['name']); ?></p>
            <p class="mail"><?php echo sanitize($userInfo['email']); ?></p>
            <p class="regist">登録日:<?php echo substr($userInfo['create_date'],0,10); ?></span>
          </div>
        </div>
        <form action="" method="post">
          <textarea name="comment" cols="30" rows="10" id="js-count" class="whisper-text" placeholder="メッセージ"></textarea>
          <p class="text-count"><span id="show-count">0</span>/140文字</p>
          <div class="block">
            <input class="send-button" type="submit" value="投稿" name="whisper">
          </div>
        </form>
        <h2 class="title">検索</h2>
        <form action="" method="get">
          <p class="err"><?php showErrMsg('name'); ?></p>
          <input type="text" name="search" class="search-text" placeholder="検索したいワード">
          <div class="selectbox">
            <select name="sort" class="select-sort">
            input
              <option value="0" >並び順</option>
              <option value="1" >新しい順</option>
              <option value="2" >古い順</option>
            </select>
          </div>
          <div class="block">
            <input class="send-button" type="submit" value="検索">
          </div>
        </form>
      </div>
  </main>

    <?php 
      require('footer.php');
    ?>
  </body>
</html>
