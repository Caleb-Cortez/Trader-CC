<?php
session_start();

/* ===== CONEXIÓN ===== */
$conn = new mysqli("localhost", "root", "", "trader");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

/* ===== LOGIN ===== */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    $sql = "SELECT * FROM usuarios WHERE correo='$correo'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $usuario = $result->fetch_assoc();
        if (password_verify($contraseña, $usuario['contraseña'])) {

            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];

            // 👉 SIEMPRE IR A TRADER
            header("Location: trader.php");
            if ($usuario['rol'] == 'admin') {
                header("Location: admin.php");
                exit();
            }

        } else {
            $error = "Contraseña incorrecta";
        }

    } else {
        $error = "Correo no encontrado";
    }
        exit();

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trader</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./style/style.css">
</head>

<body>

<nav class="navbar navbar-expand-lg bg-light shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand">TRADER</a>

        <div class="ms-auto">
            <a href="register.php" class="btn btn-primary">Registrarse</a>
        </div>
    </div>
</nav>

<div class="login-container">
    <div class="login-card">

        <h2 class="welcome-text">Bienvenido Usuario</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label>Correo</label>
                <input type="email" name="correo" class="form-control input-custom" required>
            </div>

            <div class="mb-3">
                <label>Contraseña</label>
                <input type="password" name="contraseña" class="form-control input-custom" required>
            </div>

            <button class="btn btn-primary w-100 btn-login">Iniciar sesión</button>
        </form>

    </div>
</div>

</body>
</html>
``