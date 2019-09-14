<?php 
 require('function.php');
 debug('--------------------------------');
 debug('ajax_fav.php');
 debug('--------------------------------');

 if(!empty($_POST)){
  debug('POST送信開始(ファボ機能のPOST送信開始');
  $user_id = $_SESSION['user_id'];
  $comment_id = $_POST['commentId'];
  
  $flg = getFavFlg($user_id,$comment_id);
  debug('コメントフラグ：' .$flg);


   try{
     $dbh = createDBH();
     if($flg === 0){
        //  flgが0の時はインサートして、ファボ済みにする
       $sql = 'INSERT INTO FAVORITE (user_id,comment_id) VALUES (:u_id,:c_id)';
     }else{
        // すでにファボ済みのため、デリートする
       $sql = 'DELETE FROM FAVORITE WHERE user_id = :u_id AND comment_id = :c_id';
     }
     $data = array(':u_id' => $user_id, 'c_id' => $comment_id);
     $stmt = queryExe($dbh, $sql, $data);
     debug('ファボ処理完了');
   }catch (Exception $e){
   error_log('エラー発生:' . $e->getMessage());
   }
 }
?>