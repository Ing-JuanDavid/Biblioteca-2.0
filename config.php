<?php
require_once "Biblioteca.php";

define('ARCHIVO_LIBROS', 'data/libros.txt');
define('ARCHIVO_USUARIOS', 'data/usuarios.txt');
define('ARCHIVO_PRESTAMOS', 'data/prestamos.txt');

$miBiblioteca = new Biblioteca();
$miBiblioteca->loadData();
