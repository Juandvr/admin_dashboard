<?php
include 'funciones.php';
$error = false;
$config = include 'config.php';
try {
$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
if (isset($_POST['apellido'])) {
$consultaSQL = "SELECT * FROM citas WHERE apellido LIKE '%" . $_POST['apellido'] . "%'";
} else {
$consultaSQL = "SELECT * FROM citas";
}
$sentencia = $conexion->prepare($consultaSQL);
$sentencia->execute();
$citas = $sentencia->fetchAll();
} catch(PDOException $error) {
$error= $error->getMessage();
}
$titulo = isset($_POST['apellido']) ? 'Lista de citas (' . $_POST['apellido'] . ')' : 'Lista de citas';
?>
<?php include "template/header.php"; ?>
<?php
if ($error) {
?>
<div class="container mt-2">
<div class="row">
<div class="col-md-12">
<div class="alert alert-danger" role="alert">
<?= $error ?>
</div>
</div>
</div>
</div>
<?php
}
?>
<div class="">
<div class="row">
<div class="col-md-12">
<a href="crear.php" class="btn btn-primary mt-4">Crear alumno</a>
<hr>
<form method="post" class="form-inline">
<div class="form-group mr-3">
<input type="text" id="apellido" name="apellido" placeholder="Buscar por apellido" class="form-control">
</div>
<button type="submit" name="submit" class="btn btn-primary">Ver resultados</button>
</form>
</div>
</div>
</div>
<div class="container">
<div class="row">
<div class="col-md-12">
<h2 class="mt-3"><?= $titulo ?></h2>
<table class="table">
<thead>
<tr>
<th>#</th>
<th>Nombre cliente</th>
<th>Apellido</th>
<th>Email</th>
<th>Telefono</th>
<th>Nombre mascota</th>
<th>Raza</th>
<th>Tamaño</th>
<th>Sexo</th>
<th>Fecha</th>
<th>Acciones</th>
</tr>
</thead>
<tbody>
<?php
if ($citas && $sentencia->rowCount() > 0) {
foreach ($citas as $fila) {
?>
<tr>
<td><?php echo escapar($fila["id"]); ?></td>
<td><?php echo escapar($fila["nombre_cliente"]); ?></td>
<td><?php echo escapar($fila["apellido"]); ?></td>
<td><?php echo escapar($fila["email"]); ?></td>
<td><?php echo escapar($fila["telefono"]); ?></td>
<td><?php echo escapar($fila["nombre_mascota"]); ?></td>
<td><?php echo escapar($fila["raza"]); ?></td>
<td><?php echo escapar($fila["tamano"]); ?></td>
<td><?php echo escapar($fila["sexo"]); ?></td>
<td><?php echo escapar($fila["fecha"]); ?></td>
<td>
<a href="<?= 'borrar.php?id=' . escapar($fila["id"]) ?>"> Borrar</a>
<a href="<?= 'editar.php?id=' . escapar($fila["id"]) ?>" . > Editar</a>
</td>
</tr>
<?php
}
}
?>
<tbody>
</table>
</div>
</div>
</div>
<?php include "template/footer.php"; ?>