<?php 

/* --------------------------------
 * デバッグログ設定
* -------------------------------- */
ini_set('log_errors','on');
ini_set('error_log','php.log');

$debug_flg = true;
function debug($str){
  global $debug_flg;
  // 本番環境でもログを出力する
  // if($debug_flg){
    if(true){
    error_log('deb:' . $str);
  }
}
/* --------------------------------
 * 定型分
* -------------------------------- */
define('SUC01', 'パスワードを変更しました');
define('SUC02', 'ユーザ情報を更新しました');
define('SUC03', 'メールを送信しました');
define('SUC04', 'パスワードをリセットしました');

define('ERR01','入力必須項目です');
define('ERR02','Emailの形式で入力してください');
define('ERR03','文字以上で入力してください');
define('ERR04','文字以下で入力してください');
define('ERR05','半角英数字のみ利用可能です');
define('ERR06','パスワードが一致しません。');
define('ERR07','エラー発生しました。しばらくしてからやり直してください');
define('ERR08','既に登録されているメールアドレスです');
define('ERR09','メールアドレスまたはパスワードが一致しません');
define('ERR10', '現在と異なるパスワードを設定してください');
define('ERR11', '未登録ユーザーです');
define('ERR12', 'リセットキーが間違っています');
define('ERR13', '有効期限切れです');




/* --------------------------------
 * セッション
* -------------------------------- */
session_save_path("/var/tmp/");
ini_set('session.gc_maxlifetime', 60*60*24*30);
ini_set('session.cookie_lifetime ', 60*60*24*30);
session_start();
session_regenerate_id();

function showSession(){
  debug('セッションID：'.session_id());
  debug('$_SESSION[]:'.print_r($_SESSION,true));
  debug('現在時刻:'.time());
  if(!empty($_SESSION['login_date']) && !empty($_SESSION['login_limit'])){
    debug( 'ログイン期限:'.( $_SESSION['login_date'] + $_SESSION['login_limit'] ) );
  }
}

// セッション内に格納したメッセージを一回だけ表示
if(!empty($_SESSION['msg_once'])){
    echo '<div id="js-show-msg">';
    echo $_SESSION['msg_once'];
    echo ' </div>';
    $_SESSION['msg_once'] ='';
  }
/* --------------------------------
 * ログイン認証
* -------------------------------- */
function auth(){
  if(!empty($_SESSION['login_date'])){
    debug('SESSION情報を表示');
    debug(print_r($_SESSION,true));
    if($_SESSION['login_date'] + $_SESSION['login_limit'] < time()){
      debug('ログイン済みだが有効期限切れ');
      session_destroy();
      return false;
    }else{
      debug('ログイン済みかつ有効期限内ユーザ');
      return true;
    }
  }else{
    debug('未ログインユーザ');
    return false;
  }
  // 一応リターンしておく
  return false;
}
/* --------------------------------
 * ログアウト
* -------------------------------- */
function logout(){
  session_destroy();
  header('location:login.php');
}


/* --------------------------------
 * バリデーションチェック
* -------------------------------- */
// 未入力チェック
function validEmpty($key,$str){
  if(empty($str)){
  global $err_msg;
  $err_msg[$key] = ERR01;
  }
}
// Email形式チェック
function validEmail($str){
  if(!preg_match("/[^\s]@[^\s]/",$str)){
  global $err_msg;
  $err_msg['email'] = ERR02;
  }
}
// Email重複チェック
function emailDuplicate($str){
  try{
    $dbh = createDBH();
    $sql = 'SELECT COUNT(email) FROM USERS WHERE email = :email AND delete_flg = 0';
    $data = array(':email' => $str);
    $stmt = queryExe($dbh, $sql, $data);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if(array_shift($result) > 0){
      global $err_msg;
      $err_msg['email'] = ERR08;
      return false;
    }
      return true;

  } catch (Exception $e){
  error_log('エラー発生:' . $e->getMessage());
  }
}
// 半角英数字チェック
function validHalfWidth($key,$str){
  if(!preg_match("/^[a-zA-Z0-9]+$/",$str)){
    global $err_msg;
    $err_msg[$key] = ERR05;
  }
}
// 長さチェック
function validLen($key,$str,$len = 8){
  if(strlen($str) < $len){
    global $err_msg;
    $err_msg[$key] = $len . ERR03;
  }
}
// パスワード再入力チェック
function validEqual($str1,$str2,$key){
  if($str1 !== $str2){
    global $err_msg;
    $err_msg[$key] = ERR06;
  }
  if($str1 === $str2) return true;
}
// ログイン中ユーザの現在パスワードチェック
function validPassCheck($key,$pass){
  try{
    $dbh = createDBH();
    $sql = 'SELECT pass FROM USERS WHERE user_id = :id AND delete_flg = 0';
    $data = array(':id' => $_SESSION['user_id']);
    $stmt = queryExe($dbh, $sql, $data);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if(password_verify($pass,$result['pass'])){
      debug('パスワード一致');
      return true;
    }
    debug('パスワード不一致');
    global $err_msg;
    $err_msg[$key] = ERR06;
  }catch (Exception $e){
  error_log('エラー発生:' . $e->getMessage());
  }
}


/* --------------------------------
 * 入力フォーム用
* -------------------------------- */
// サニタイズ
function sanitize($str){
  // return $str;
  return htmlspecialchars($str, ENT_QUOTES);
}

// 入力フォーム維持
function formRemain($key){
  if(!empty($_POST[$key])) echo sanitize($_POST[$key]);
}

/* --------------------------------
 * 入力フォームエラー出力用
* -------------------------------- */
// 入力フォームエラーチェック用(クラス追加)
function errDetect($key){
  global $err_msg;
  if(!empty($err_msg[$key])) echo 'err';
}
// 入力フォームエラーチェック用(メッセージ出力)
function showErrMsg($key){
  global $err_msg;
  if(!empty($err_msg[$key])) echo $err_msg[$key];
}

/* --------------------------------
 * DB
* -------------------------------- */
function CreateDBH(){
  global $debug_flg;
  if($debug_flg === true){
    //検証環境
    debug('検証環境');
    $dsn = 'mysql:dbname=Portfolio1;host=localhost;charset=utf8';
    $user = 'root';
    $password = 'root';
  }else{
    //本番環境
    debug('本番環境');
    $dsn = 'mysql:dbname=LAA1093375-portfolio1;host=mysql140.phy.lolipop.lan;charset=utf8';
    debug('DSN = ' .$dsn);
    $user = 'LAA1093375';
    $password = 'SCHB';
  }
  $options = array(
    // デフォルトフェッチモードを連想配列形式に設定
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // SELECTでrowcount()を有効化
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
  );
  $dbh = new PDO($dsn, $user, $password, $options);
  return $dbh;
}

function queryExe($dbh, $sql, $data){
  $stmt = $dbh->prepare($sql);
  if(!$stmt->execute($data)){
    debug('SQL実行エラー');
    debug('SQL：'.print_r($stmt,true));
    debug(print_r($stmt->errorInfo(),true));
    global $err_msg;
    $err_msg['common'] = ERR07;
    return 0;
  }
  debug('クエリ成功。');
  return $stmt;
}

/* --------------------------------
 * ユーザー情報取得
* -------------------------------- */
function getUser($id){
  try{
    $dbh = createDBH();
    $sql = 'SELECT user_id,name,email,avatar,create_date FROM USERS WHERE user_id = :id AND delete_flg = 0';
    $data = array(':id' => $id);
    $stmt = queryExe($dbh, $sql, $data);
    return($stmt->fetch(PDO::FETCH_ASSOC));
  } catch (Exception $e){
  error_log('エラー発生:' . $e->getMessage());
  }
}
function getMes($serch,$orderFlg){
  debug('getMes(search) =' .$serch);
  $order = ($orderFlg === 0) ? 'DESC' : 'ASC';
  try{
    $dbh = createDBH();
    if(!empty($serch)){
      $sql = 'SELECT C.user_id as user_id,comment_id,avatar,name,comment,send_date FROM COMMENT AS C LEFT JOIN USERS AS U ON C.user_id = U.user_id WHERE C.comment LIKE :serch AND C.delete_flg = 0 ORDER BY send_date ' .$order ;

      $data = array(':serch' => '%'.$serch.'%');
    }else{
      $sql = 'SELECT C.user_id as user_id,comment_id,avatar,name,comment,send_date FROM COMMENT AS C LEFT JOIN USERS AS U ON C.user_id = U.user_id WHERE C.delete_flg = 0 ORDER BY send_date ' .$order ;
      $data = array();
    }
    debug('SQL');
    debug(print_r($sql,true)); 
    $stmt = queryExe($dbh, $sql, $data);
    debug('SQLエラーを取得');
    print_r($stmt->errorInfo(),true);
    return($stmt->fetchAll());

  } catch (Exception $e){
  error_log('エラー発生:' . $e->getMessage());
  }
}
/* --------------------------------
 * メール送信
* -------------------------------- */
function sendMail($from, $to, $subject, $body){
    if(!empty($to) && !empty($subject) && !empty($body)){

      mb_language("Japanese"); 
      mb_internal_encoding("UTF-8"); 
        
      $result = mb_send_mail($to, $subject, $body, "From: ".$from);
      if ($result) {
        debug('メール送信完了');
      } else {
        debug('メールの送信に失敗。');
      }
    }
}
function sender(){
  global $debug_flg;
  if($debug_flg === true) return 'info@takahisa.work';
  return 'webwervice.takaku@gmail.com';
}

/* --------------------------------
 * その他
* -------------------------------- */
function getSessionMsg(){
  if(!empty($_SESSION['msg_once'])){
    echo '<div id="js-show-msg">';
    echo $_SESSION['msg_once'];
    echo ' </div>';
  }
}
// 引数が空でない時にechoで出力する
function echoStr($str){
  if(!empty($str)) echo sanitize($str);
}

// ファイルアップロード処理
function uploadAvatar($file,$key){
  debug('アップロード処理開始');

  if(isset($file['error']) && is_int($file['error'])){
    try{
      switch ($file['error']) {
        case UPLOAD_ERR_OK: // OK
            break;
        case UPLOAD_ERR_NO_FILE:   // ファイル未選択の場合
            throw new RuntimeException('ファイルが選択されていません');
        case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズが超過した場合
        case UPLOAD_ERR_FORM_SIZE: // フォーム定義の最大サイズ超過した場合
            throw new RuntimeException('ファイルサイズが大きすぎます');
        default: // その他の場合
            throw new RuntimeException('その他のエラーが発生しました');
      }

      // 対応するイメージタイプかチェック
      $type = @exif_imagetype($file['tmp_name']);
      debug('イメージタイプ:' .print_r($type,true));
      if (!in_array($type, [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG], true)) { 
          throw new RuntimeException('画像形式が未対応です');
      }

      $path = 'img/avatar/'.sha1_file($file['tmp_name']).image_type_to_extension($type);
      if (!move_uploaded_file($file['tmp_name'], $path)) { 
          throw new RuntimeException('ファイル保存時にエラーが発生しました');
      }
      // 権限を変更
      chmod($path, 0644);
      
      debug('ファイルパス：'.$path);
      return $path;

    } catch (RuntimeException $e) {

      debug($e->getMessage());
      global $err_msg;
      $err_msg[$key] = $e->getMessage();

    }
  }
}

// ランダム文字列生成
function makeRandKey($len = 4){
  $str = 'ABCDEFGHIJLKMNOPQRSTUVWXYZ0123456789';
  $key = '';
  for($i = 0; $i < $len; $i++){
    $key .= $str[mt_rand(0,35)];
  }
  return $key;
}

// ログインユーザーが対象コメントをお気に入り登録しているか判定
function getFavFlg($u_id,$c_id){
  try{
    $dbh = createDBH();
    $sql = 'SELECT COUNT(*) FROM FAVORITE WHERE user_id = :user_id AND comment_id = :comment_id';
    $data = array(':user_id' => $u_id, ':comment_id' => $c_id);
    $stmt = queryExe($dbh, $sql, $data);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if(array_shift($result) === '0'){
      debug('ファボ無し');
      return 0;
    }else{
      debug('ファボ済み');
      return 1;
    }    
  }catch (Exception $e){
  error_log('エラー発生:' . $e->getMessage());
  }
}