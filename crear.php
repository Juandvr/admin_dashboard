<?php
include 'db_connection.php';

$resultado = '';
$error = false;

if (isset($_POST['submit'])) {
    // Obtener los datos del formulario
    $ID_Cliente = $_POST['ID_Cliente'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $password = $_POST['contraseña'];

    // Encriptar la contraseña
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Preparar y ejecutar la consulta SQL
    $stmt = $conn->prepare("INSERT INTO cliente (ID_Cliente, nombre, apellidos, telefono, email, direccion, contraseña) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $ID_Cliente, $nombre, $apellidos, $telefono, $email, $direccion, $password_hash);

    if ($stmt->execute()) {
        $resultado = "Usuario agregado con exito.";
    } else {
        $resultado = "Error: " . $stmt->error;
        $error = true;
    }

    $stmt->close();
    $conn->close();
}
?>

<?php include "template/header.php"; ?>

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
    <div class="container" id="formuRegistro">
        <div class="row" style="justify-content: center">
            <div class="col-6">
                <h2>Agregar usuario</h2>
                <form method="post">
                    <input type="text" name="ID_Cliente" placeholder="Digita tu identificacion" class="form-control" /><br />
                    <input type="text" name="nombre" placeholder="Digita tu nombre" class="form-control" /><br />
                    <input type="text" name="apellidos" placeholder="Digita tus apellidos" class="form-control" /><br />
                    <input type="text" name="telefono" placeholder="Digita tu telefono" class="form-control" /><br />
                    <input type="email" name="email" placeholder="Digita tu email" class="form-control" /><br />
                    <input type="text" name="direccion" placeholder="Digita tu direccion" class="form-control" /><br />
                    <input type="password" name="contraseña" placeholder="Digita tu contraseña" class="form-control" /><br />
                    <input type="submit" name="submit" value="Agregar usuario" class="btn btn-danger" />
                </form>
                <br />
            </div>
        </div>
    </div>

<?php include "template/footer.php"; ?>