<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trader</title>
</head>
<body>

<h1>Bienvenido <?php echo $_SESSION['nombre']; ?></h1>

<a >logout.phpCerrar sesión</a>

</body>
</html>
