<?php 
session_start();
session_destroy();
$_SESSION=[];
session_unset();

// cookie

setcookie('cook', '', time() -3600);
setcookie('kie', '', time() -3600);

header("Location: ../login.php");
?>