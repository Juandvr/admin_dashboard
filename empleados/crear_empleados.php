<?php
include '../db_connection.php';

$resultado = '';
$error = false;

if (isset($_POST['submit'])) {
    // Obtener los datos del formulario
    $ID_Empleados = $_POST['ID_Empleados'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];

    // Preparar y ejecutar la consulta SQL
    $stmt = $conn->prepare("INSERT INTO empleados (ID_Empleados, nombre, apellidos, telefono, correo, direccion) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $ID_Empleados, $nombre, $apellidos, $telefono, $email, $direccion);

    if ($stmt->execute()) {
        $resultado = "Empleado agregado con exito.";
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
            <h2 class="mt-4">Agregar un empleado</h2>
            <hr>
            <form method="post">
                <div class="form-group">
                    <label for="ID_Empleados">Identificacion</label>
                    <input type="text" name="ID_Empleados" placeholder="Digita la identificacion" class="form-control" /><br />
                </div>
                <br>
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" placeholder="Digita el nombre" class="form-control" /><br />
                </div>
                <br>
                <div class="form-group">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" name="apellidos" placeholder="Digita los apellidos" class="form-control" /><br />
                </div>
                <br>
                <div class="form-group">
                    <label for="telefono">Telefono</label>
                    <input type="text" name="telefono" placeholder="Digita el telefono" class="form-control" /><br />
                </div>
                <br>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="Digita el email" class="form-control" /><br />
                </div>
                <br>
                <div class="form-group">
                    <label for="direccion">Direccion</label>
                    <input type="text" name="direccion" placeholder="Digita la direccion" class="form-control" /><br />
                </div>
                <br>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary" value="Agregar empleado"> 
                </div>
                <br>
            </form>
        </div>
    </div>
</div>

<?php include "../template/footer.php"; ?>