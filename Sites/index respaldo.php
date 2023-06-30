<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('./templates/header.html');

?>

<body>
    <div class='main'>
        <h1 class='title'> Décor </h1>
        <?php
        if (empty($_SESSION['username'])) {
        ?>
        <div>
            <form method="POST" action="./queries/login.php">
                <input type="text" name="username">
                <input type="password" name="password">
                <button type="submit" name="login">Login</button>
            </form>
        </div>
        <?php } ?>

        <?php if (isset($_SESSION['username'])) { ?>
        <div>
            <h1>¡Hola <?php echo $_SESSION['username']; ?>!</h1>

        </div>
        <form method="POST" action="./queries/logout.php">
            <button name="logout">Logout</button>
        </form>
        <?php } ?>
        <div class='container'>
            <h3>Importar usuarios</h3>
            <form action='./queries/importar_usuarios.php' method='POST'>
                <input class='btn' type='submit' value='Importar usuarios'>
            </form>
        </div>
    </div>
    <footer>
        <p>
        </p>
    </footer>

</body>
</html>