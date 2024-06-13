<?php
include '../funciones.php';
$error = false;
$config = include '../config.php';
try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    $consultaSQL = "SELECT * FROM citas";
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();
    $citas = $sentencia->fetchAll();
} catch (PDOException $error) {
    $error = $error->getMessage();
}
$titulo = 'Lista de citas';
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
            <a href="citas/crear_citas.php" class="btn btn-primary mt-4">Agendar una cita</a>
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
                        <th>ID Cliente</th>
                        <th>ID Mascota</th>
                        <th>fecha</th>
                        <th>hora</th>
                        <th>ID Servicio</th>
                        <th>creado</th>
                        <th>actualizado</th>
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
                                <td><?php echo escapar($fila["ID_Cliente"]); ?></td>
                                <td><?php echo escapar($fila["ID_Mascota"]); ?></td>
                                <td><?php echo escapar($fila["fecha"]); ?></td>
                                <td><?php echo escapar($fila["hora"]); ?></td>
                                <td><?php echo escapar($fila["ID_Servicio"]); ?></td>
                                <td><?php echo escapar($fila["creado"]); ?></td>
                                <td><?php echo escapar($fila["actualizado"]); ?></td>
                                <td>
                                    <a href="<?= 'citas/borrar_citas.php?id=' . escapar($fila["id"]) ?>">🗑️Borrar</a>
                                    <a href="<?= 'citas/editar_citas.php?id=' . escapar($fila["id"]) ?>" .>✏️Editar</a>
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