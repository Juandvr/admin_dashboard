<?php
include 'funciones.php';
$config = include 'config.php';
$resultado = [
'error' => false,
'mensaje' => ''
];
if (!isset($_GET['id'])) {
$resultado['error'] = true;
$resultado['mensaje'] = 'La cita no existe';
}
if (isset($_POST['submit'])) {
try {
$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
$cita = [
"id" => $_GET['id'],
"nombre_cliente" => $_POST['nombre_cliente'],
"apellido" => $_POST['apellido'],
"email" => $_POST['email'],
"telefono" => $_POST['telefono'],
"nombre_mascota" => $_POST['nombre_mascota'],
"raza" => $_POST['raza'],
"tamano" => $_POST['tamano'],
"sexo" => $_POST['sexo'],
"fecha" => $_POST['fecha']
];
$consultaSQL = "UPDATE citas SET
nombre_cliente = :nombre_cliente,
apellido = :apellido,
email = :email,
telefono = :telefono,
nombre_mascota = :nombre_mascota,
raza = :raza,
tamano = :tamano,
sexo = :sexo,
fecha = :fecha,
updated_at = NOW()
WHERE id = :id";

$consulta = $conexion->prepare($consultaSQL);
$consulta->execute($cita);
} catch(PDOException $error) {
$resultado['error'] = true;
$resultado['mensaje'] = $error->getMessage();
}
}
try {
$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
$id = $_GET['id'];
$consultaSQL = "SELECT * FROM citas WHERE id =" . $id;
$sentencia = $conexion->prepare($consultaSQL);
$sentencia->execute();
$cita = $sentencia->fetch(PDO::FETCH_ASSOC);
if (!$cita) {
$resultado['error'] = true;
$resultado['mensaje'] = 'No se ha encontrado el cita';
}
} catch(PDOException $error) {
$resultado['error'] = true;
$resultado['mensaje'] = $error->getMessage();
}
?>
<?php require "template/header.php"; ?>
<?php

if ($resultado['error']) {
?>
<div class="container mt-2">
<div class="row">
<div class="col-md-12">
<div class="alert alert-danger" role="alert">
<?= $resultado['mensaje'] ?>
</div>
</div>
</div>
</div>
<?php
}
?>
<?php
if (isset($_POST['submit']) && !$resultado['error']) {
?>
<div class="container mt-2">
<div class="row">
<div class="col-md-12">
<div class="alert alert-success" role="alert">
La cita ha sido actualizada correctamente
</div>
</div>
</div>
</div>
<?php
}
?>
<?php
if (isset($cita) && $cita) {
?>
<div class="container">
<div class="row">
<div class="col-md-12">
<h2 class="mt-4">Editando la cita de <?= escapar($cita['nombre_cliente']) . ' ' . escapar($cita['apellido']) ?></h2>
<hr>
<form method="post">
<div class="form-group">
<label for="nombre_cliente">Nombre cliente</label>
<input type="text" name="nombre_cliente" id="nombre_cliente" value="<?= escapar($cita['nombre_cliente']) ?>" class="form-control">
</div>
<div class="form-group">
<label for="apellido">Apellido</label>
<input type="text" name="apellido" id="apellido" value="<?= escapar($cita['apellido']) ?>" class="form-control">
</div>
<div class="form-group">
<label for="email">Email</label>
<input type="email" name="email" id="email" value="<?= escapar($cita['email']) ?>" class="form-control">
</div>
<div class="form-group">
<label for="telefono">Telefono</label>
<input type="text" name="telefono" id="telefono" value="<?= escapar($cita['telefono']) ?>" class="form-control">
</div>
<div class="form-group">
<label for="nombre_mascota">Nombre mascota</label>
<input type="text" name="nombre_mascota" id="nombre_mascota" value="<?= escapar($cita['nombre_mascota']) ?>" class="form-control">
</div>
<div class="form-group">
<label for="raza">Raza</label>
<input type="text" name="raza" id="raza" value="<?= escapar($cita['raza']) ?>" class="form-control">
</div>
<div class="form-group">
<label for="tamano">Tamaño</label>
<input type="text" name="tamano" id="tamano" value="<?= escapar($cita['tamano']) ?>" class="form-control">
</div>
<div class="form-group">
<label for="sexo">Sexo</label>
<input type="text" name="sexo" id="sexo" value="<?= escapar($cita['sexo']) ?>" class="form-control">
</div>
<div class="form-group">
<label for="fecha">Fecha</label>
<input type="date" name="fecha" id="fecha" value="<?= escapar($cita['fecha']) ?>" class="form-control">
</div>
<div class="form-group">
<input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
<a class="btn btn-primary" href="index.php">Regresar al inicio</a>
</div>
</form>
</div>
</div>
</div>
<?php
}
?>
<?php require "template/footer.php"; ?>