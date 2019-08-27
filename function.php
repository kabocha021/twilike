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



?>