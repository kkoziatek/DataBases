<?php session_start();

session_destroy();

header('Location: podstrona4.php');

exit;
?>