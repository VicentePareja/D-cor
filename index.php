<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('./templates/header.html');

?>

<html>
<head>
<style>
body {
    font-family: Arial, sans-serif;
}

.container {
    width: 80%;
    margin: 0 auto;
}

.title {
    text-align: center;
    padding: 20px;
    color: #333;
}

.input-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.input-container input {
    padding: 5px;
    font-size: 14px;
}

.button {
    padding: 10px 20px;
    background-color: #007BFF;
    color: white;
    border: none;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    transition-duration: 0.4s;
}

.button:hover {
    background-color: #0056b3;
    color: white;
}
</style>
</head>
<body>
    <div class='container'>
        <h1 class='title'> Décor </h1>
        <?php
        if (empty($_SESSION['username'])) {
        ?>
        <div>
            <form method="POST" action="./queries/login.php">
                <div class="input-container">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username">
                </div>
                <div class="input-container">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password">
                </div>
                <button class="button" type="submit" name="login">Login</button>
            </form>
        </div>
        <?php } ?>

        <?php if (isset($_SESSION['username'])) { ?>
        <div>
            <h1>¡Hola <?php echo $_SESSION['username']; ?>!</h1>
        </div>
        <form method="POST" action="./queries/logout.php">
            <button class="button" name="logout">Logout</button>
        </form>
        <?php } ?>
        <div>
            <h3>Importar usuarios</h3>
            <form action='./queries/importar_usuarios.php' method='POST'>
                <input class='button' type='submit' value='Importar usuarios'>
            </form>
        </div>
    </div>
    <footer>
        <p>
        </p>
    </footer>
</body>
</html>