<?php
require_once 'db_con.php';


$corepage = explode('/', $_SERVER['PHP_SELF']);
$corepage = end($corepage);

if ($corepage !== 'index.php') {
    if ($corepage == $corepage) {
        $corepage = explode('.', $corepage);
        header('Location: index.php?page=' . $corepage[0]);
    }
}

$id = isset($_GET['id']) ? base64_decode($_GET['id']) : 0; // Asegúrate de manejar el caso en que 'id' no esté definido en la URL.

if (isset($_POST['userupdate'])) {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    // Validación de entrada
    $errors = [];

    if (empty($name)) {
        $errors['name'] = "Nombre Completo es requerido.";
    } elseif (!preg_match('/^[A-Za-z\s]+$/', $name)) {
        $errors['name'] = "El Nombre Completo solo puede contener letras y espacios.";
    }

    if (empty($email)) {
        $errors['email'] = "Correo Electrónico es requerido.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Correo Electrónico no es válido.";
    }

    if (count($errors) === 0) {
        // Utilizar una consulta preparada para evitar la inyección SQL
        $query = "UPDATE `users` SET `name`=?, `email`=? WHERE `id`=?";
        $stmt = mysqli_prepare($db_con, $query);
        mysqli_stmt_bind_param($stmt, 'ssi', $name, $email, $id);

        if (mysqli_stmt_execute($stmt)) {
            header('Location: index.php?page=user-profile&edit=success');
            exit;
        } else {
            header('Location: index.php?page=user-profile&edit=error');
            exit;
        }
    }
}

// Obtener datos del usuario
$query = "SELECT `name`, `email` FROM `users` WHERE `id`=?";
$stmt = mysqli_prepare($db_con, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

$nameOutput = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
$emailOutput = htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8');
?>

<h1 class="text-primary"><i class="fas fa-user-plus"></i> Editar Información de Usuario<small class="text-warning"> Editar Usuario</small></h1>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Panel de Control </a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="index.php?page=user-profile">Perfil de Usuario </a></li>
        <li class="breadcrumb-item active" aria-current="page">Editar Perfil de Usuario</li>
    </ol>
</nav>

<div class="row">
    <div class="col-sm-6">
        <form enctype="multipart/form-data" method="POST" action="">
            <div class="form-group">
                <label for="name">Nombre Completo (máximo 50 caracteres)</label>
                <input name="name" type="text" class="form-control" id="name" value="<?= $nameOutput; ?>" required maxlength="50">
                <?php if (isset($errors['name'])) : ?>
                    <p class="text-danger"><?= $errors['name']; ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input name="email" type="email" class="form-control" id="email" value="<?= $emailOutput; ?>" required>
                <?php if (isset($errors['email'])) : ?>
                    <p class="text-danger"><?= $errors['email']; ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group text-center">
                <input name="userupdate" value="Actualizar Perfil" type="submit" class="btn btn-danger">
            </div>
        </form>
    </div>
</div>
