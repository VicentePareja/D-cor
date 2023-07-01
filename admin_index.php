<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require("config/conexion.php");
include('./templates/header.html');
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="./styles/style.css">
</head>
<body>
    <div class="title">
        <h1> Décor </h1>
    </div>
    <div class='container'>
        
        <?php if (isset($_SESSION['username'])) { ?>
            <div>
            <h1>¡Hola <?php echo $_SESSION['username']; ?>!</h1>
            </div>
        <?php } ?>
        
        <?php
        $query = "SELECT nombre FROM Regiones";
        $result = $db2->prepare($query);
        $result->execute();
        $regiones = $result->fetchAll(PDO::FETCH_COLUMN); ?>
            <h3>Seleccionar Región</h3>
            <form action='./region.php' method='POST'>
                <select class='select' name='region'>
                    <?php foreach ($regiones as $region) { ?>
                        <option value='<?php echo $region; ?>'><?php echo $region; ?></option>
                    <?php } ?>
                </select>
                <br>
                <button class='button' type='submit'>Consultar</button>
            </form>
        
        <?php if (isset($_SESSION['username'])) { ?>
            <br>
            <form method="POST" action="./queries/logout.php">
                <button class='button' name="logout">Logout</button>
            </form>
        <?php } ?>
    </div>
    <footer>
        <p>
        </p>
    </footer>
</body>
</html>