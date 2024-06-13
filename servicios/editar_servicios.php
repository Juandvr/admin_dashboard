<?php
include '../funciones.php';
$config = include '../config.php';
$resultado = [
    'error' => false,
    'mensaje' => ''
];
if (!isset($_GET['id'])) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'El servicio no existe';
}
if (isset($_POST['submit'])) {
    try {
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
        $usuario = [
            "id" => $_GET['id'],
            "nombre" => $_POST['nombre'],
            "descripcion" => $_POST['descripcion'],
            "precio" => $_POST['precio'],
        ];
        $consultaSQL = "UPDATE servicios SET
nombre = :nombre,
descripcion = :descripcion,
precio = :precio
WHERE ID_Servicios = :id";

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
    $consultaSQL = "SELECT * FROM servicios WHERE ID_Servicios =" . $id;
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();
    $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);
    if (!$usuario) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'No se ha encontrado el servicio';
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
                    El servicio ha sido actualizado correctamente
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
                <h2 class="mt-4">Editando el servicio: <?= escapar($usuario['nombre']) ?></h2>
                <hr>
                <form method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" value="<?= escapar($usuario['nombre']) ?>" class="form-control">
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="descripcion">Descripcion</label>
                        <input type="text" name="descripcion" id="descripcion" value="<?= escapar($usuario['descripcion']) ?>" class="form-control">
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="text" name="precio" id="precio" value="<?= escapar($usuario['precio']) ?>" class="form-control">
                    </div>
                    <br>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-primary" value="Actualizar"> 
                    </div>
                    <br>
                    <div class="form-group" id="regresar">
                        <a class="btn btn-primary" href="servicios/index_servicios.php">Regresar al inicio</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
}
?>
<?php require "../template/footer.php"; ?>