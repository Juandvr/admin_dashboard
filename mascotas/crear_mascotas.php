<?php
include '../db_connection.php';

$resultado = '';
$error = false;

if (isset($_POST['submit'])) {
    // Obtener los datos del formulario
    $ID_Mascota = $_POST['ID_Mascota'];
    $nombre = $_POST['nombre'];
    $raza = $_POST['raza'];
    $sexo = $_POST['sexo'];
    $ID_Cliente = $_POST['ID_Cliente'];
    $tamaño = $_POST['tamaño'];

    // Preparar y ejecutar la consulta SQL
    $stmt = $conn->prepare("INSERT INTO mascota (ID_Mascota, nombre, raza, sexo, ID_Cliente, tamaño) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $ID_Mascota, $nombre, $raza, $sexo, $ID_Cliente, $tamaño);

    if ($stmt->execute()) {
        $resultado = "Mascota agregada con exito.";
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
            <h2 class="mt-4">Agregar una mascota</h2>
            <hr>
            <form method="post">
                <div class="form-group">
                    <label for="ID_Mascota">ID</label>
                    <input type="text" name="ID_Mascota" placeholder="Digita un id" class="form-control" /><br />
                </div>
                <br>
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" placeholder="Digita el nombre" class="form-control" /><br />
                </div>
                <br>
                <div class="form-group">
                    <label for="raza">raza</label>
                    <input type="text" name="raza" placeholder="Digita la raza" class="form-control" /><br />
                </div>
                <br>
                <div class="form-group">
                    <label for="sexo">Sexo</label>
                    <input type="text" name="sexo" placeholder="Digita el sexo" class="form-control" /><br />
                </div>
                <br>
                <div class="form-group">
                    <label for="ID_Cliente">ID dueño</label>
                    <input type="ID_Cliente" name="ID_Cliente" placeholder="Digita el ID del dueño" class="form-control" /><br />
                </div>
                <br>
                <div class="form-group">
                    <label for="tamaño">Tamaño</label>
                    <input type="text" name="tamaño" placeholder="Digita el tamaño" class="form-control" /><br />
                </div>
                <br>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary" value="Agregar mascota"> 
                </div>
                <br>
            </form>
        </div>
    </div>
</div>

<?php include "../template/footer.php"; ?>