<?php
include '../db_connection.php';

$resultado = '';
$error = false;

if (isset($_POST['submit'])) {
    // Obtener los datos del formulario
    $ID_Servicios = $_POST['ID_Servicios'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    // Preparar y ejecutar la consulta SQL
    $stmt = $conn->prepare("INSERT INTO servicios (ID_Servicios, nombre, descripcion, precio) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $ID_Servicios, $nombre, $descripcion, $precio);

    if ($stmt->execute()) {
        $resultado = "Servicio agregado con exito.";
    } else {
        $resultado = "Error: " . $stmt->error;
        $error = true;
    }

    $stmt->close();
    $conn->close();
}
?>

<?php include "../template/header.php"; ?>

<?php if (!empty($resultado)) { ?>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-<?= $error ? 'danger' : 'success' ?>" role="alert">
                    <?= $resultado ?>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="container" id="formucita">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-4">Agregar un servicio</h2>
            <hr>
            <form method="post">
                <div class="form-group">
                    <label for="ID_Servicios">ID</label>
                    <input type="text" name="ID_Servicios" placeholder="Digita el id" class="form-control" /><br />
                </div>
                <br>
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" placeholder="Digita el nombre" class="form-control" /><br />
                </div>
                <br>
                <div class="form-group">
                    <label for="descripcion">Descripcion</label>
                    <input type="text" name="descripcion" placeholder="Digita la descripcion" class="form-control" /><br />
                </div>
                <br>
                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input type="text" name="precio" placeholder="Digita el precio" class="form-control" /><br />
                </div>
                <br>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary" value="Agregar servicio"> 
                </div>
                <br>
            </form>
        </div>
    </div>
</div>

<?php include "../template/footer.php"; ?>