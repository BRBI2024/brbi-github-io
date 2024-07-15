<?php
session_start();
session_destroy();
$url = 'index1.php';
header('Location: ' . $url);

?>