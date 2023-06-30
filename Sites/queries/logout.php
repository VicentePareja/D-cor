<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
// Destruir la sesión y redirigir al usuario a index.php
session_destroy();
header('Location: https://codd.ing.puc.cl/~grupo30/index.php');
exit;
?>
