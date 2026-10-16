<?php
session_start();
$_SESSION = [];
session_destroy();

header("Location: pelanggan.php");
exit;
?>