<?php
include '../funciones.php';
$config = include '../config.php';
$resultado = [
    'error' => false,
    'mensaje' => ''
];
if (!isset($_GET['id'])) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'La mascota no existe';
}
if (isset($_POST['submit'])) {
    try {
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
        $usuario = [
            "id" => $_GET['id'],
            "nombre" => $_POST['nombre'],
            "raza" => $_POST['raza'],
            "sexo" => $_POST['sexo'],
            "tamano" => $_POST['tamaño']
        ];
        $consultaSQL = "UPDATE mascota SET
nombre = :nombre,
raza = :raza,
sexo = :sexo,
tamaño = :tamano
WHERE ID_Mascota = :id";

        $consulta = $conexion->prepare($consultaSQL);
        $consulta->execute($usuario);
    } catch (PDOException $error) {
        $resultado['error'] = true;
        $resultado['mensaje'] = $error->getMessage();
    }
}
try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    $id = $_GET['id'];
    $consultaSQL = "SELECT * FROM mascota WHERE ID_Mascota =" . $id;
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();
    $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);
    if (!$usuario) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'No se ha encontrado la mascota';
    }
} catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
}
?>
<?php require "../template/header.php"; ?>
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
                    La mascota ha sido actualizada correctamente
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
<?php
if (isset($usuario) && $usuario) {
?>
    <div class="container" id="formeditar">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-4">Editando la mascota <?= escapar($usuario['nombre']) ?></h2>
                <hr>
                <form method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" value="<?= escapar($usuario['nombre']) ?>" class="form-control">
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="raza">Raza</label>
                        <input type="text" name="raza" id="raza" value="<?= escapar($usuario['raza']) ?>" class="form-control">
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="sexo">Sexo</label>
                        <input type="text" name="sexo" id="sexo" value="<?= escapar($usuario['sexo']) ?>" class="form-control">
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="tamaño">Tamaño</label>
                        <input type="tamaño" name="tamaño" id="tamaño" value="<?= escapar($usuario['tamaño']) ?>" class="form-control">
                    </div>
                    <br>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-primary" value="Actualizar"> 
                    </div>
                    <br>
                    <div class="form-group" id="regresar">
                        <a class="btn btn-primary" href="mascotas/index_mascotas.php">Regresar al inicio</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
}
?>
<?php require "../template/footer.php"; ?>