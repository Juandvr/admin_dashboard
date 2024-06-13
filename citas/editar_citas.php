<?php
include '../funciones.php';
$config = include '../config.php';
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
        $usuario = [
            "id" => $_GET['id'],
            "ID_Cliente" => $_POST['ID_Cliente'],
            "ID_Mascota" => $_POST['ID_Mascota'],
            "fecha" => $_POST['fecha'],
            "hora" => $_POST['hora'],
            "servicio" => $_POST['servicio']
        ];
        $consultaSQL = "UPDATE citas SET
ID_Cliente = :ID_Cliente,
ID_Mascota = :ID_Mascota,
fecha = :fecha,
hora = :hora,
ID_Servicio = :servicio
WHERE id = :id";

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
    $consultaSQL = "SELECT * FROM citas WHERE id =" . $id;
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();
    $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);
    if (!$usuario) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'No se ha encontrado la cita';
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
                    La cita ha sido actualizado correctamente
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
                <h2 class="mt-4">Editando la cita #<?= escapar($usuario['id'])?></h2>
                <hr>
                <form method="post">
                    <div class="form-group">
                        <label for="ID_Cliente">ID Cliente</label>
                        <input type="text" name="ID_Cliente" id="ID_Cliente" value="<?= escapar($usuario['ID_Cliente']) ?>" class="form-control">
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="ID_Mascota">ID Mascota</label>
                        <input type="text" name="ID_Mascota" id="ID_Mascota" value="<?= escapar($usuario['ID_Mascota']) ?>" class="form-control">
                    </div>
                    <br>
                    <div class="form-group">
                    <label for="servicio">Servicio</label>
                    <select name="servicio" id="servicio" class="form-control" required>
                        <?php
                        // Obtener los servicios preestablecidos desde la base de datos
                        $sqlServicios = "SELECT * FROM servicios";
                        foreach ($conexion->query($sqlServicios) as $servicio) {
                            echo "<option value='" . $servicio['ID_Servicios'] . "'>" . htmlspecialchars($servicio['nombre']) . " - $" . htmlspecialchars($servicio['precio']) . "</option>";
                        }
                        ?>
                    </select>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input type="date" name="fecha" id="fecha" value="<?= escapar($usuario['fecha']) ?>" class="form-control">
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="hora">Hora</label>
                        <input type="time" name="hora" id="hora" value="<?= escapar($usuario['hora']) ?>" class="form-control">
                    </div>
                    <br>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-primary" value="Actualizar"> 
                    </div>
                    <br>
                    <div class="form-group" id="regresar">
                        <a class="btn btn-primary" href="citas/index_citas.php">Regresar al inicio</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
}
?>
<?php require "../template/footer.php"; ?>