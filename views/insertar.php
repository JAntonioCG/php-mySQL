<?php
include '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar entradas
    $nombre = trim($_POST['nombre']);
    $apaterno = trim($_POST['apaterno']);
    $amaterno = trim($_POST['amaterno']);
    $fecha = $_POST['fecha_nacimiento'];
    $estatura = $_POST['estatura'];
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];

    if (empty($nombre) || empty($apaterno) || empty($amaterno) || empty($fecha) || empty($estatura) || empty($usuario) || empty($password)) {
        header('Location: panel.php?error=datanovale');
        exit();
    }

    $password_hashed = password_hash($password, PASSWORD_BCRYPT);

    // Verificar si el usuario ya existe
    $sql_usuario = "SELECT * FROM alumnos WHERE usuario = ?";
    $result = $conexion->prepare($sql_usuario);
    $result->bind_param('s', $usuario);
    $result->execute();
    $exist = $result->get_result();

    if ($exist->num_rows > 0) {
        header('Location: panel.php?error=usuarioexiste');
        exit();
    }

    // Insertar nuevo alumno
    $sql_insertar = "INSERT INTO alumnos (nombre, apaterno, amaterno, fecha_nacimiento, estatura, usuario, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $insertar = $conexion->prepare($sql_insertar);
    $insertar->bind_param('sssssss', $nombre, $apaterno, $amaterno, $fecha, $estatura, $usuario, $password_hashed);

    if ($insertar->execute()) {
        header('Location: panel.php?success=alumnoagregado');
    } else {
        $error = $insertar->error;
        header("Location: panel.php?error=nosepudoagregar&details=$error");
    }

    // Cerrar conexión
    $conexion->close();
}
?>
