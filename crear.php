<?php
include 'funciones.php';
if (isset($_POST['submit'])) {
$resultado = [
'error' => false,
'mensaje' => 'La cita para ' . escapar($_POST['nombre_cliente']) . ' ha sido agregada con éxito'
];
$config = include 'config.php';
try {
$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
$cita = array(
"nombre_cliente" => $_POST['nombre_cliente'],
"apellido" => $_POST['apellido'],
"email" => $_POST['email'],
"telefono" => $_POST['telefono'],
"nombre_mascota" => $_POST['nombre_mascota'],
"raza" => $_POST['raza'],
"tamano" => $_POST['tamano'],
"sexo" => $_POST['sexo'],
"fecha" => $_POST['fecha'],
);
$consultaSQL = "INSERT INTO citas (nombre_cliente, apellido, email, telefono, nombre_mascota, raza, tamano, sexo, fecha) values (:" . implode(", :", array_keys($cita)) . ")";
$sentencia = $conexion->prepare($consultaSQL);
$sentencia->execute($cita);
} catch(PDOException $error) {
$resultado['error'] = true;
$resultado['mensaje'] = $error->getMessage();
}
}
?>

<?php include "template/header.php"; ?>

            <?php
            if (isset($resultado)) {
            ?>
            <div class="container mt-3">
            <div class="row">
            <div class="col-md-12">
            <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
            <?= $resultado['mensaje'] ?>
            </div>
            </div>
            </div>
            </div>
            <?php
            }
            ?>
            <div class="container">
            <div class="row">
            <div class="col-md-12">
            <h2 class="mt-4">Crea una cita</h2>
            <hr>
            <form method="post">
            <div class="form-group">
            <label for="nombre_cliente">Nombre cliente</label>
            <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control">
            </div>
            <div class="form-group">
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" class="form-control">
            </div>
            <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control">
            </div>
            <div class="form-group">
            <label for="telefono">Telefono</label>
            <input type="text" name="telefono" id="telefono" class="form-control">
            </div>
            <div class="form-group">
            <label for="nombre_mascota">Nombre mascota</label>
            <input type="text" name="nombre_mascota" id="nombre_mascota" class="form-control">
            </div>
            <div class="form-group">
            <label for="raza">Raza</label>
            <input type="text" name="raza" id="raza" class="form-control">
            </div>
            <div class="form-group">
            <label for="tamano">Tamaño</label>
            <input type="text" name="tamano" id="tamano" class="form-control">
            </div>
            <div class="form-group">
            <label for="sexo">Sexo</label>
            <input type="text" name="sexo" id="sexo" class="form-control">
            </div>
            <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control">
            </div>
            <div class="form-group">
            <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
            <a class="btn btn-primary" href="index.php">Regresar al inicio</a>
            </div>
            </form>
            </div>
            </div>
            </div>

<?php include "templates/footer.php"; ?>