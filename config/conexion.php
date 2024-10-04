<?php
  $servidor = 'localhost:8889';
  $usuario = 'root';
  $password = 'root';
  $bd = 'crudphp';

  $conexion = new mysqli($servidor, $usuario, $password, $bd);
  if ($conexion->connect_error) {
    die('Conexion Fallida: ' . $conexion->connect_error);
  }
?>