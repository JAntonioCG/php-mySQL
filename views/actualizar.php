<?php
  include '../config/conexion.php';

  // Verificar conexión a la base de datos
  if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = trim($_POST['nombre']);
    $apaterno = trim($_POST['apaterno']);
    $amaterno = trim($_POST['amaterno']);
    $fecha = $_POST['fecha_nacimiento'];
    $estatura = $_POST['estatura'];
    $usuario = trim($_POST['usuario']);

    // Depuración: Mostrar datos recibidos
    echo "Datos recibidos: ID = $id, Nombre = $nombre, Usuario = $usuario, Fecha = $fecha, Estatura = $estatura <br>";

    // Verificar si el usuario ya existe en otro registro
    $sql_busca = "SELECT * FROM alumnos WHERE usuario = ? AND id != ?";
    $resultado = $conexion->prepare($sql_busca);

    // Depuración: Verificar si la consulta fue preparada correctamente
    if (!$resultado) {
      echo "Error en la preparación de la consulta de búsqueda: " . $conexion->error;
      exit();
    }

    $resultado->bind_param('si', $usuario, $id);
    $resultado->execute();
    $exist = $resultado->get_result();

    // Depuración: Mostrar si se encontró otro usuario
    if ($exist->num_rows > 0) {
      echo "Usuario ya existe en otro registro.";
      exit();
    } else {
      echo "Usuario no duplicado, procediendo con la actualización.<br>";
    }

    // Actualizar el registro
    $sql_update = "UPDATE alumnos SET nombre = ?, apaterno = ?, amaterno = ?, fecha_nacimiento = ?, estatura = ?, usuario = ? WHERE id = ?";
    $update = $conexion->prepare($sql_update);

    // Depuración: Verificar si la consulta de actualización fue preparada correctamente
    if (!$update) {
      echo "Error en la preparación de la consulta de actualización: " . $conexion->error;
      exit();
    }

    $update->bind_param('ssssssi', $nombre, $apaterno, $amaterno, $fecha, $estatura, $usuario, $id);

    // Depuración: Ejecutar la consulta y verificar si fue exitosa
    if ($update->execute()) {
      // Depuración: Mostrar el número de filas afectadas
      if ($update->affected_rows > 0) {
        echo "Actualización exitosa. Filas afectadas: " . $update->affected_rows . "<br>";
        header('Location: panel.php?mensaje=UsuarioActualizado');
      } else {
        echo "Actualización exitosa, pero no se afectaron filas. Filas afectadas: " . $update->affected_rows . "<br>";
        header('Location: panel.php?mensaje=SinCambios');
      }
    } else {
      echo "Error en la ejecución de la consulta de actualización: " . $conexion->error;
      exit();
    }
  }
?>

