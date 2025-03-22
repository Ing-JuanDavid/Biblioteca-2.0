<?php
require_once "config.php";
require_once "Libro.php";
require_once "Biblioteca.php";

// Instanciar la biblioteca y cargar los datos
$biblioteca = new Biblioteca();
$biblioteca->loadData();

// Agregar nuevo libro si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isbn = $_POST["isbn"];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $materia = $_POST['materia'];


    $nuevoLibro = new Libro($isbn, $titulo, $autor, $materia);
    $biblioteca->addBook($nuevoLibro);

    // Redirigir para evitar reenvío del formulario
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Biblioteca</title>
</head>
<body>
    <h1>Listado de Libros</h1>

    <table border="1" cellpadding="5">
        <tr>
            <th>Isbn</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Materia</th>
        </tr>
        <?php foreach ($biblioteca->libros as $libro): ?>
        <tr>
            <td><?= $libro->isbn ?></td>
            <td><?= $libro->titulo ?></td>
            <td><?= $libro->autor ?></td>
            <td><?= $libro->materia ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Agregar Nuevo Libro</h2>
    <form method="post">
        <label>Isbn:</label><br>
        <input type="text" name="isbn" required><br>

        <label>Título:</label><br>
        <input type="text" name="titulo" required><br>

        <label>Autor:</label><br>
        <input type="text" name="autor" required><br>

        <label>Materia:</label><br>
        <input type="text" name="materia" required><br><br>

        <input type="submit" value="Agregar Libro">
    </form>

    <br><a href="busqueda.php">Ir a Búsqueda de Libros</a>
</body>
</html>