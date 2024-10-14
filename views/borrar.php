<?php
  include '../config/conexion.php';
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $sql_borrar = "DELETE FROM alumnos WHERE id = ?";
    $result = $conexion->prepare($sql_borrar);
    $result->bind_param('i', $id);
    if ($result->execute()) {
      header('Location: panel.php?mensaje=borrado');
    } else {
      header('Location: panel.php?error=no se pudo borrar');
    }
  }
?>