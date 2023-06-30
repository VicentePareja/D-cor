<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require("config/conexion.php");
include('./templates/header.html');
?>

<body>
    <div class='main'>
        <h1 class='title'> Décor </h1>
        <?php if (isset($_SESSION['username'])) { ?>
            <div>
            <h1>¡Hola <?php echo $_SESSION['username']; ?>!</h1>
            </div>
        <?php } ?>
        <div class='container'>
        <?php
        // Consulta SQL para obtener los nombres de la tabla Regiones
        $query = "SELECT nombre FROM Regiones";
        $result = $db2->prepare($query);
        $result->execute();
        $regiones = $result->fetchAll(PDO::FETCH_COLUMN); ?>
            <h3>Seleccionar Región</h3>
            <form action='./queries/region.php' method='POST'>
                <select name='region'>
                    <?php foreach ($regiones as $region) { ?>
                        <option value='<?php echo $region; ?>'><?php echo $region; ?></option>
                    <?php } ?>
                </select>
                <input class='btn' type='submit' value='Consultar'>
            </form>
        </div>
        <?php if (isset($_SESSION['username'])) { ?>
                <form method="POST" action="./queries/logout.php">
                <button name="logout">Logout</button>
            </form>
            <?php } ?>
    </div>
    <footer>
        <p>
        </p>
    </footer>
</body>
</html>