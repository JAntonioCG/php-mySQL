<?php
  session_start();
  if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
  }
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
                    <button class='btn btn-danger'
                      data-bs-toggle='modal'
                      data-bs-target='#borrarModal'
                      data-id='{$alumno['id']}'>
                      BORRAR
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

<!-- MOdal para insertar -->

  <div class="modal fade" id="insertarModal" tabindex="-1" aria-labelledby="insertarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="insertar.php" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="insertarModalLabel">Agregar Alumnos</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="nombre" class="from-label">Nombre</label>
              <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="apaterno" class="from-label">Apaterno</label>
              <input type="text" name="apaterno" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="amaterno" class="from-label">Amaterno</label>
              <input type="text" name="amaterno" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="fecha_nacimiento" class="from-label">Fecha de nacimiento</label>
              <input type="date" name="fecha_nacimiento" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="estatura" class="from-label">Estatura</label>
              <input type="text" name="estatura" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="usuario" class="from-label">Usuario</label>
              <input type="text" name="usuario" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="password" class="from-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">CANCELAR</button>
            <button class="btn btn-primary" type="submit">AGREGAR</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<!-- MOdal para actualizar -->

  <div class="modal fade" id="actualizarModal" tabindex="-1" aria-labelledby="actualizarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="actualizar.php" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="actualizarModalLabel">Actualizar Alumnos</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="actualizar-id">
            <div class="mb-3">
              <label for="nombre" class="from-label">Nombre</label>
              <input type="text" name="nombre" class="form-control" required id="actualizar-nombre">
            </div>
            <div class="mb-3">
              <label for="apaterno" class="from-label">Apaterno</label>
              <input type="text" name="apaterno" class="form-control" required id="actualizar-apaterno">
            </div>
            <div class="mb-3">
              <label for="amaterno" class="from-label">Amaterno</label>
              <input type="text" name="amaterno" class="form-control" required id="actualizar-amaterno">
            </div>
            <div class="mb-3">
              <label for="fecha_nacimiento" class="from-label">Fecha de nacimiento</label>
              <input type="date" name="fecha_nacimiento" class="form-control" required id="actualizar-fecha_nacimiento">
            </div>
            <div class="mb-3">
              <label for="estatura" class="from-label">Estatura</label>
              <input type="text" name="estatura" class="form-control" required id="actualizar-estatura">
            </div>
            <div class="mb-3">
              <label for="usuario" class="from-label">Usuario</label>
              <input type="text" name="usuario" class="form-control" required id="actualizar-usuario">
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">CANCELAR</button>
            <button class="btn btn-primary" type="submit">ACTUALIZAR</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<!-- MOdal para Borrar -->

<div class="modal fade" id="borrarModal" tabindex="-1" aria-labelledby="borrarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="borrar.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="borrarModalLabel">Borrar Alumnos</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="borrar-id">
                    <p>¿ESTÁS SEGURO?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">CANCELAR</button>
                    <button class="btn btn-danger" type="submit">BORRAR</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
let actualizarModal = document.getElementById('actualizarModal');
actualizarModal.addEventListener('show.bs.modal', (e) => {
  let button = e.relatedTarget;
  let id = button.getAttribute('data-id');
  let nombre = button.getAttribute('data-nombre');
  let apaterno = button.getAttribute('data-apaterno');
  let amaterno = button.getAttribute('data-amaterno');
  let fecha = button.getAttribute('data-fecha_nacimiento');
  let estatura = button.getAttribute('data-estatura');
  let usuario = button.getAttribute('data-usuario');

  let modal = actualizarModal;
  modal.querySelector('#actualizar-id').value = id;
  modal.querySelector('#actualizar-nombre').value = nombre;
  modal.querySelector('#actualizar-apaterno').value = apaterno;
  modal.querySelector('#actualizar-amaterno').value = amaterno;
  modal.querySelector('#actualizar-fecha_nacimiento').value = fecha;
  modal.querySelector('#actualizar-estatura').value = estatura;
  modal.querySelector('#actualizar-usuario').value = usuario;
  })
  let borrarModal = document.getElementById('borrarModal');
  borrarModal.addEventListener('show.bs.modal', (e) => {
    let button = e.relatedTarget;
    let id = button.getAttribute('data-id'); // Corregido aquí
    let modal = borrarModal; // Cambiado 'this' a 'borrarModal'
    modal.querySelector('#borrar-id').value = id;
});

</script>
<script src="../js/app.js"></script>
</body>
</html>
