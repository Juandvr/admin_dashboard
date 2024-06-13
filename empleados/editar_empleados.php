<?php
include '../funciones.php';
$config = include '../config.php';
$resultado = [
    'error' => false,
    'mensaje' => ''
];
if (!isset($_GET['id'])) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'El empleado no existe';
}
if (isset($_POST['submit'])) {
    try {
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
        $usuario = [
            "id" => $_GET['id'],
            "nombre" => $_POST['nombre'],
            "apellidos" => $_POST['apellidos'],
            "telefono" => $_POST['telefono'],
            "email" => $_POST['email'],
            "direccion" => $_POST['direccion']
        ];
        $consultaSQL = "UPDATE empleados SET
nombre = :nombre,
apellidos = :apellidos,
telefono = :telefono,
correo = :email,
direccion = :direccion
WHERE ID_Empleados = :id";

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
    $consultaSQL = "SELECT * FROM empleados WHERE ID_Empleados =" . $id;
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();
    $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);
    if (!$usuario) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'No se ha encontrado el empleado';
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
                    El empleado ha sido actualizado correctamente
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
                <h2 class="mt-4">Editando el empleado <?= escapar($usuario['nombre']) . ' ' . escapar($usuario['apellidos']) ?></h2>
                <hr>
                <form method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" value="<?= escapar($usuario['nombre']) ?>" class="form-control">
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="apellidos">Apellidos</label>
                        <input type="text" name="apellidos" id="apellidos" value="<?= escapar($usuario['apellidos']) ?>" class="form-control">
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="telefono">Telefono</label>
                        <input type="text" name="telefono" id="telefono" value="<?= escapar($usuario['telefono']) ?>" class="form-control">
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?= escapar($usuario['correo']) ?>" class="form-control">
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="direccion">Direccion</label>
                        <input type="text" name="direccion" id="direccion" value="<?= escapar($usuario['direccion']) ?>" class="form-control">
                    </div>
                    <br>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-primary" value="Actualizar"> 
                    </div>
                    <br>
                    <div class="form-group" id="regresar">
                        <a class="btn btn-primary" href="empleados/index_empleados.php">Regresar al inicio</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
}
?>
<?php require "../template/footer.php"; ?>