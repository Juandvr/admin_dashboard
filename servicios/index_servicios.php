<?php
include '../funciones.php';
$error = false;
$config = include '../config.php';
try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    $consultaSQL = "SELECT * FROM servicios";
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();
    $servicios = $sentencia->fetchAll();
} catch (PDOException $error) {
    $error = $error->getMessage();
}
$titulo = 'Lista de servicios';
?>
<?php include "../template/header.php"; ?>
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
            <a href="servicios/crear_servicios.php" class="btn btn-primary mt-4">Agregar un servicio</a>
            <hr>
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
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($servicios && $sentencia->rowCount() > 0) {
                        foreach ($servicios as $fila) {
                    ?>
                            <tr>
                                <td><?php echo escapar($fila["ID_Servicios"]); ?></td>
                                <td><?php echo escapar($fila["nombre"]); ?></td>
                                <td><?php echo escapar($fila["descripcion"]); ?></td>
                                <td><?php echo escapar($fila["precio"]); ?></td>
                                <td>
                                    <a href="<?= 'servicios/borrar_servicios.php?id=' . escapar($fila["ID_Servicios"]) ?>">🗑️Borrar</a>
                                    <a href="<?= 'servicios/editar_servicios.php?id=' . escapar($fila["ID_Servicios"]) ?>" .>✏️Editar</a>
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