<?php
  require('function.php');
  debug('--------------------------------');
  debug('index.php');
  debug('--------------------------------');

  if(!auth()){
    debug('ログイン画面へ遷移');
    header('location:header.php');
  }
?>
<!DOCTYPE html>
<html lang="ja">
  <?php 
    $pageTitle = '投稿一覧';
    require('head.php');
    require('header.php');
  ?>
  <body>
    <main id="main" class="site-width">
      <h2 class="title">投稿一覧</h2>
      <div class="main-column">
        
        <div class="whisper-box mine">
          <div class="img-box">
            <img src="img/avator/sample1.png" alt="">
          </div>
          <div class="whisper-contents">
            <p class="username">ゲスト１</p>
            <p class="send-date">2019-08-02</p>
            <p class="whisper-value">テストメッセージテストメッセージテストメッセージテストメッセージテストメッセージテストメッセージテストメッセージ</p>
          </div>
        </div>

        <div class="whisper-box other">
          <div class="img-box">
            <img src="img/avator/sample1.png" alt="">
          </div>
          <div class="whisper-contents">
            <p class="username">ゲスト2</p>
            <p class="send-date">2019-08-02</p>
            <p class="whisper-value">テストメッセージテストメッセージテストメッセージテストメッセージテストメッセージテストメッセージテストメッセージ</p>
          </div>
        </div>
        

      </div>
      <div class="side-menu">
        <div class="prof">
          <div class="img-box">
            <img src="img/avator/sample1.png" alt="">
          </div>
          <div class="prof-info">
            <p class="username">ゲスト1</p>
            <p class="mail">test@test</p>
            <p class="regist">登録日 2019.08.25</span>
          </div>
        </div>
        <textarea name="whisper" cols="30" rows="10" class="whisper-text" placeholder="メッセージ"></textarea>
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
