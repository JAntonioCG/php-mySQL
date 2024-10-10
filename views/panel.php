<?php
/*
  session_start();
  if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
  }
*/
  include '../config/conexion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>PANEL - PHP + MySQL</title>
</head>
<body>
  <div class="container mt-5">
    <h2>Bienvenido, <?php echo $_SESSION['usuario']; ?></h2>

    <button class="btn btn-success mb-3" type="button" data-bs-toggle="modal" data-bs-target="#insertarModal">Agregar Alumno</button>
    <table class="table table-striped table-success">
      <thead>
        <tr>
          <th>ID</th>
          <th>NOMBRE</th>
          <th>APATERNO</th>
          <th>AMATERNO</th>
          <th>FECHA-DE-NACIMIENTO</th>
          <th>ESTATURA</th>
          <th>USUARIO</th>
          <th>ACCIONES</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $select = "SELECT * FROM alumnos";
          if ($resultado = $conexion->query($select)) {
            if ($resultado->num_rows > 0) {
              while($alumno = $resultado->fetch_assoc()) {
                echo "<tr>";
                  echo "<td>" . $alumno["id"] . "</td>";
                  echo "<td>" . $alumno["nombre"] . "</td>";
                  echo "<td>" . $alumno["apaterno"] . "</td>";
                  echo "<td>" . $alumno["amaterno"] . "</td>";
                  echo "<td>" . $alumno["fecha_nacimiento"] . "</td>";
                  echo "<td>" . $alumno["estatura"] . "</td>";
                  echo "<td>" . $alumno["usuario"] . "</td>";
                  echo "<td>
                    <button class='btn btn-warning'
                      data-bs-toggle='modal'
                      data-bs-target='#actualizarModal'
                      data-id='{$alumno['id']}'
                      data-nombre='{$alumno['nombre']}'
                      data-apaterno='{$alumno['apaterno']}'
                      data-amaterno='{$alumno['amaterno']}'
                      data-fecha_nacimiento='{$alumno['fecha_nacimiento']}'
                      data-estatura='{$alumno['estatura']}'
                      data-usuario='{$alumno['usuario']}'>
                      ACTUALIZAR
                    </button>
                  </td>";
                  echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='8'>No hay alumnos disponibles</td></tr>";
            }
          } else {
            echo "Error en la consulta: " . $conexion->error;
          }
        ?>
      </tbody>
    </table>
  </div>

  <div class="modal fade" id="insertarModal" tabindex="-1" aria-labelledby="insertarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="insertar.php" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="insertarModalLabel">Agregar Alumnos</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
        </form>
      </div>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
