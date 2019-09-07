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
    error_log('deb:' . $str);
  }
}
/* --------------------------------
 * 定型分
* -------------------------------- */
define('SUC01', 'パスワードを変更しました');
define('SUC02', 'ユーザ情報を更新しました');


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
function getMes($order_flg){
  $order = ($order_flg === 0) ? 'DESC' : 'ASC';
  try{
    $dbh = createDBH();
    $sql = 'SELECT C.user_id as user_id,avatar,name,comment,send_date FROM COMMENT AS C LEFT JOIN USERS AS U ON C.user_id = U.user_id WHERE C.delete_flg = 0 ORDER BY send_date ' .$order ;

    debug('SQL');
    debug(print_r($sql,true)); 
    $data = array(':order' => $order);
    $stmt = queryExe($dbh, $sql, $data);
    debug('SQLエラーを取得');
    print_r($stmt->errorInfo(),true);
    return($stmt->fetchAll());

  } catch (Exception $e){
  error_log('エラー発生:' . $e->getMessage());
  }
}
/* --------------------------------
 * その他
* -------------------------------- */
//セッションから一回だけ値を取得(取得後は削除する)
function getSessionMsg($key){
  if(!empty($_SESSION[$key])) echo $_SESSION[$key];
  $_SESSION[$key] = '';
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
        // $file['mime']の値はブラウザ側で偽装可能なので、MIMEタイプを自前でチェックする
        // exif_imagetype関数は「IMAGETYPE_GIF」「IMAGETYPE_JPEG」などの定数を返す
        $type = @exif_imagetype($file['tmp_name']);
        debug('イメージタイプ:' .print_r($type,true));
        if (!in_array($type, [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG], true)) { 
            throw new RuntimeException('画像形式が未対応です');
        }

        // ファイルデータからSHA-1ハッシュを取ってファイル名を決定し、ファイルを保存する
        // ハッシュ化しておかないとアップロードされたファイル名そのままで保存してしまうと同じファイル名がアップロードされる可能性があり、
        // DBにパスを保存した場合、どっちの画像のパスなのか判断つかなくなってしまう
        // image_type_to_extension関数はファイルの拡張子を取得するもの
        $path = 'img/avatar/'.sha1_file($file['tmp_name']).image_type_to_extension($type);
        if (!move_uploaded_file($file['tmp_name'], $path)) { //ファイルを移動する
            throw new RuntimeException('ファイル保存時にエラーが発生しました');
        }
        // 保存したファイルパスのパーミッション（権限）を変更する
        chmod($path, 0644);
        
        debug('ファイルは正常にアップロードされました');
        debug('ファイルパス：'.$path);
        return $path;

    } catch (RuntimeException $e) {

      debug($e->getMessage());
      global $err_msg;
      $err_msg[$key] = $e->getMessage();

    }
  }
}