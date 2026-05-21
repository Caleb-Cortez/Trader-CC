<?php
session_start();

/* ===== CONEXIÓN ===== */
$conn = new mysqli("localhost", "root", "", "trader");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

/* ===== REGISTRO ===== */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $passwordPlano = $_POST['contraseña'];

    // 🔐 ENCRIPTAR CONTRASEÑA
    $contraseña = password_hash($passwordPlano, PASSWORD_DEFAULT);

    // ✅ VALIDAR SI EL CORREO YA EXISTE
    $check = $conn->query("SELECT * FROM usuarios WHERE correo='$correo'");

    if ($check->num_rows > 0) {
        $error = "El correo ya está registrado";
    } else {

        $sql = "INSERT INTO usuarios (nombre, correo, contraseña) 
                VALUES ('$nombre', '$correo', '$contraseña')";

        if ($conn->query($sql)) {
            // ✅ REGISTRO EXITOSO
            header("Location: index.php");
            exit();
        } else {
            $error = "Error al registrar usuario";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registro - Trader</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- CSS -->
<link rel="stylesheet" href="./style/style.css">

</head>

<body>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar navbar-expand-lg bg-light shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">TRADER</a>
        </div>
    </nav>
    <!-- ===== FORMULARIO ===== -->
    <div class="login-container">

        <div class="login-card">

            <h2 class="welcome-text">Crear cuenta</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger text-center">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST">

                <!-- Nombre -->
                <div class="mb-3">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" name="nombre" class="form-control input-custom" required>
                </div>

                <!-- Correo -->
                <div class="mb-3">
                    <label class="form-label">Correo</label>
                    <input type="email" name="correo" class="form-control input-custom" required>
                </div>

                <!-- Contraseña -->
                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="contraseña" class="form-control input-custom" required>
                </div>

                <!-- Botón -->
                <button type="submit" class="btn btn-primary w-100 btn-login">
                    Registrarse
                </button>

            </form>

            <!-- Link al login -->
            <p class="text-center mt-3">
                ¿Ya tienes cuenta? 
                <a href="index.php">Inicia sesión</a>
            </p>

        </div>

    </div>

</body>
</html>
