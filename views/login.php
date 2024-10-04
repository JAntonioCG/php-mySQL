<?php
  session_start();
  include '../config/conexion.php';
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $busca = 'SELECT * FROM alumnos WHERE usuario = ?';
    $prep = $conexion->prepare($busca);
    $prep->bind_param('s', $usuario);
    $prep->execute();
    $alumno = $prep->get_result();

    if ($alumno->num_rows > 0) {
      $dato = $alumno->fetch_assoc();
      if (password_verify($password, $dato['password'])) {
        $_SESSION['usuario'] = $usuario;
        header('Location: panel.php');
        exit();
      } else {
        $error = 'Contraña incorrecta';  
      }
    } else {
      $error = 'Alumno no encontrado';
    }
  }
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bootstrap demo</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-4">
        <form action="" method="post">
          <div class="mb-3">
            <label for="usuario" class="from-label">Usuario:</label>
            <input type="text" class="from-control" required name="usuario">
          </div>
          <div class="mb-3">
            <label for="password" class="from-label">Password:</label>
            <input type="password" class="from-control" required name="password">
          </div>
          <button type="submit" class="btn btn-primary w-100">LOGIN</button>
          <?php if (!empty($error)): ?>
            <div class="alert alert-danger mt-3">
              <?php echo $error; ?>
            </div>
          <?php endif; ?>
        </form>
      </div>
    </div>
  </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>