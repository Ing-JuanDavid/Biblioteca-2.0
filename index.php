<?php
require_once "config.php";
require_once "Libro.php";
require_once "Usuario.php";
require_once "Prestamo.php";
require_once "Biblioteca.php";

$biblioteca = new Biblioteca();
$biblioteca->loadData();

// Agregar Libro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_book'])) {
    $nuevoLibro = new Libro($_POST['isbn'], $_POST['titulo'], $_POST['autor'], $_POST['materia']);
    $biblioteca->addBook($nuevoLibro);
    header("Location: index.php");
    exit();
}

// Agregar Usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $nuevoUsuario = new Usuario(count($biblioteca->usuarios) + 1, $_POST['nombre'], $_POST['telefono']);
    $biblioteca->addUser($nuevoUsuario);
    header("Location: index.php");
    exit();
}

// Registrar Préstamo
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_loan'])) {
    $nuevoPrestamo = new Prestamo(count($biblioteca->prestamos) + 1, $_POST['usuario_id'], $_POST['isbn'], date("Y-m-d"));
    $biblioteca->prestamos[] = $nuevoPrestamo;
    $biblioteca->saveData();
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Gestión de Biblioteca</h1>
    <div class="container">
        <!-- Listado de Libros -->
        <section>
            <h2>Libros</h2>
            <table>
                <tr><th>ISBN</th><th>Título</th><th>Autor</th><th>Materia</th></tr>
                <?php foreach ($biblioteca->libros as $libro): ?>
                <tr>
                    <td><?= $libro->isbn ?></td>
                    <td><?= $libro->titulo ?></td>
                    <td><?= $libro->autor ?></td>
                    <td><?= $libro->materia ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>

        <!-- Formulario para agregar libro -->
        <form method="post">
            <h2>Agregar Libro</h2>
            <input type="text" name="isbn" placeholder="ISBN" required>
            <input type="text" name="titulo" placeholder="Título" required>
            <input type="text" name="autor" placeholder="Autor" required>
            <input type="text" name="materia" placeholder="Materia" required>
            <button type="submit" name="add_book">Agregar</button>
        </form>

        <!-- Listado de Usuarios -->
        <section>
            <h2>Usuarios</h2>
            <table>
                <tr><th>ID</th><th>Nombre</th><th>Teléfono</th></tr>
                <?php foreach ($biblioteca->usuarios as $usuario): ?>
                <tr>
                    <td><?= $usuario->id ?></td>
                    <td><?= $usuario->nombre ?></td>
                    <td><?= $usuario->telefono ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>

        <!-- Formulario para agregar usuario -->
        <form method="post">
            <h2>Agregar Usuario</h2>
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="telefono" placeholder="Teléfono" required>
            <button type="submit" name="add_user">Agregar</button>
        </form>

        <!-- Listado de Préstamos -->
        <section>
            <h2>Préstamos</h2>
            <table>
                <tr><th>ID</th><th>Usuario</th><th>Libro</th><th>Fecha</th></tr>
                <?php foreach ($biblioteca->prestamos as $prestamo): ?>
                <tr>
                    <td><?= $prestamo->id ?></td>
                    <td><?= $biblioteca->getNameUser($prestamo->idUsuario) ?></td>
                    <td><?= $biblioteca->getNameBook($prestamo->isbn) ?></td>
                    <td><?= $prestamo->fecha ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>

        <!-- Formulario para registrar préstamo -->
        <form method="post">
            <h2>Registrar Préstamo</h2>
            <select name="usuario_id" required>
                <option value="">Seleccionar Usuario</option>
                <?php foreach ($biblioteca->usuarios as $usuario): ?>
                <option value="<?= $usuario->id ?>"><?= $usuario->nombre ?></option>
                <?php endforeach; ?>
            </select>
            <select name="isbn" required>
                <option value="">Seleccionar Libro</option>
                <?php foreach ($biblioteca->libros as $libro): ?>
                <option value="<?= $libro->isbn ?>"><?= $libro->titulo ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" name="add_loan">Registrar</button>
        </form>
    </div>
</body>
</html>

