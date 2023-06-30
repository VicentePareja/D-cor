<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    require("../config/conexion.php");
    include('../templates/header.html');

    $query = "SELECT * FROM usuarios ORDER BY id;";
    $result = $db2 -> prepare($query);
    $result -> execute();
    $usuarios = $result -> fetchAll();
?>

    <body>
        <table class='table'>
            <thead>
                <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Region</th>
                <th>Password</th>
                <th>Tipo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($usuarios as $usuario) {
                    echo "<tr> <td>$usuario[0]</td> <td>$usuario[1]</td> <td>$usuario[2]</td> <td>$usuario[3]</td> <td>$usuario[4]</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <footer>
            <p>
            </p>
        </footer>

    </body>
</html>