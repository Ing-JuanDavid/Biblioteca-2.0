<?php
require_once "config.php";
require_once "Libro.php";
require_once "Usuario.php";
require_once "Prestamo.php";


class Biblioteca {
    
    // Constructor que carga los datos desde los archivos planos
    public function __construct(
        public $libros = [],
        public $usuarios = [],
        public $prestamos = []
    ) {
        $this->loadData();
    }

    public function loadData() {
        $this->libros = [];
        $this->usuarios = [];
        $this->prestamos = [];
        if (file_exists(ARCHIVO_LIBROS)) {
            $lineas = file(ARCHIVO_LIBROS, FILE_IGNORE_NEW_LINES);
            foreach ($lineas as $linea) {
                $this->libros[] = Libro::lineToLibro($linea);
            }
        }

        if(file_exists(ARCHIVO_USUARIOS)) {
            $lineas = file(ARCHIVO_USUARIOS, FILE_IGNORE_NEW_LINES);
            foreach ($lineas as $linea) {
                $this->usuarios[] = Usuario::lineToUsuario($linea);
            }
        }

        if(file_exists(ARCHIVO_PRESTAMOS)) {
            $lineas = file(ARCHIVO_PRESTAMOS, FILE_IGNORE_NEW_LINES);
            foreach ($lineas as $linea) {
                $this->prestamos[] = Prestamo::lineToPrestamo($linea);
            }
        }
    }

    public function saveData() {

        $lineas = array_map(function($libro) {
            return $libro->toLine();
        }, $this->libros);
        file_put_contents(ARCHIVO_LIBROS, implode("\n", $lineas));

        $lineas = array_map(function($usuario) {
            return $usuario->toLine();
        }, $this->usuarios);
        file_put_contents(ARCHIVO_USUARIOS, implode("\n", $lineas));

        $lineas = array_map(function($prestamo) {
            return $prestamo->toLine();
        }, $this->prestamos);
        file_put_contents(ARCHIVO_PRESTAMOS, implode("\n", $lineas));
    }

    public function searchBook($termino) {
        $resultado = [];
        foreach ($this->libros as $libro) {
            if (
                stripos($libro->titulo, $termino) !== false ||
                stripos($libro->autor, $termino) !== false ||
                stripos($libro->materia, $termino) !== false
            ) {
                $resultado[] = $libro;
            }
        }
        return $resultado;
    }

    public function addBook($libro) {
        $this->libros[] = $libro;
        $this->saveData();
    }

    public function addUser($usuario) {
        $this->usuarios[] = $usuario;
        $this->saveData();
    }

    // public function registerLoan($usuarioId, $libroId, $fecha) {
    //     $prestamo = new Prestamo($usuarioId, $libroId, $fecha);
    //     $this->prestamos[] = $prestamo;
    //     $this->saveData();
    // }

    public function getNameUser($usuarioId) {
        foreach ($this->usuarios as $usuario) {
            if ($usuario->id == $usuarioId) {
                return $usuario->nombre;
            }
        }
    }

    public function getNameBook($libroId) {
        foreach ($this->libros as $libro) {
            if ($libro->id == $libroId) {
                return $libro->titulo;
            }
        }
    }
}