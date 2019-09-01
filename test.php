<?php 
$pw1 = "password";
$hash1 = password_hash($pw1,PASSWORD_BCRYPT);
echo "ハッシュ1<br>";
echo $hash1 ."<br>";

$pw2 = "password";
$hash2 = password_hash($pw2,PASSWORD_BCRYPT);
echo "ハッシュ2<br>";
echo $hash2;
?>