<?php 

/* --------------------------------
 * デバッグログ設定
* -------------------------------- */
ini_set('log_errors','on');
ini_set('error_log','php.log');

$debug_flg = true;
function debug($str){
  global $debug_flg;
  if($debug_flg){
    error_log('デバッグ：'.$str);
  }
}

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

/* --------------------------------
 * ログイン認証
* -------------------------------- */
function auth(){
  if(!empty($_SESSION['login_date'])){
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
 * 定型分
* -------------------------------- */
define('ERR01','入力必須項目です');
define('ERR02','Emailの形式で入力してください');
define('ERR03','文字以上で入力してください');
define('ERR04','文字以下で入力してください');
define('ERR05','半角英数字のみ利用可能です');
define('ERR06','パスワードが一致しません。');
define('ERR07','エラー発生しました。しばらくしてからやり直してください');
define('ERR08','既に登録されているメールアドレスです');
define('ERR09','メールアドレスまたはパスワードが一致しません');



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
}


/* --------------------------------
 * 入力フォーム用
* -------------------------------- */
// サニタイズ
function sanitize($str){
  return htmlspecialchars($str, ENT_QUOTES);
}

// 入力フォーム維持
function formRemain($key){
  if(!empty($_POST[$key])) echo sanitize($_POST[$key]);
}

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
  $dsn = 'mysql:dbname=Portfolio1;host=localhost;charset=utf8';
  $user = 'root';
  $password = 'root';
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
function getUserInfo($id){
  
}

/* --------------------------------
 * その他
* -------------------------------- */