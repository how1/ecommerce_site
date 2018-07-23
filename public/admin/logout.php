<?php 
session_start();
session_destroy();
if (isset($_COOKIE['auto-login'])){
	  unset($_COOKIE['remember_me']);
}
header("Location: ../../public"); 
?>