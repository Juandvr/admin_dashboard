<?php
include '../funciones.php';
$error = false;
$config = include '../config.php';
try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    $consultaSQL = "SELECT * FROM mascota";
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();
    $mascota = $sentencia->fetchAll();
} catch (PDOException $error) {
    $error = $error->getMessage();
}
$titulo = 'Lista de mascotas';
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
            <a href="mascotas/crear_mascotas.php" class="btn btn-primary mt-4">Agregar una mascota</a>
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
                        <th>Raza</th>
                        <th>Sexo</th>
                        <th>ID Cliente</th>
                        <th>Tamaño</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($mascota && $sentencia->rowCount() > 0) {
                        foreach ($mascota as $fila) {
                    ?>
                            <tr>
                                <td><?php echo escapar($fila["ID_Mascota"]); ?></td>
                                <td><?php echo escapar($fila["nombre"]); ?></td>
                                <td><?php echo escapar($fila["raza"]); ?></td>
                                <td><?php echo escapar($fila["sexo"]); ?></td>
                                <td><?php echo escapar($fila["ID_Cliente"]); ?></td>
                                <td><?php echo escapar($fila["tamaño"]); ?></td>
                                <td>
                                    <a href="<?= 'mascotas/borrar_mascotas.php?id=' . escapar($fila["ID_Mascota"]) ?>">🗑️Borrar</a>
                                    <a href="<?= 'mascotas/editar_mascotas.php?id=' . escapar($fila["ID_Mascota"]) ?>" .>✏️Editar</a>
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
<?php include "../template/footer.php"; ?>