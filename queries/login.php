<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require("../config/conexion.php");
include('../templates/header.html');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM usuarios WHERE nombre = ? AND clave = ?";
    $statement = $db2->prepare($query);
    $statement->bindValue(1, $username);
    $statement->bindValue(2, $password);
    $statement->execute();
    $result = $statement->fetchAll();

    if (count($result) > 0) {
        $_SESSION['username'] = $username;
        $userType = $result[0]['tipo'];

        if ($userType === 'Admin') {
            header('Location: https://codd.ing.puc.cl/~grupo30/admin_index.php');
        } elseif ($userType === 'Cliente') {
            header('Location: https://codd.ing.puc.cl/~grupo30/client_index.php');
        } else {
            echo "<h2 class='subtitle'>Tipo de usuario desconocido</h2>";
        }
        exit;
    } else {
        echo "<h2 class='subtitle'>Credenciales inválidas</h2>";
    }

    $statement->closeCursor();
}
?>
