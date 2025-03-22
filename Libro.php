<?php
class Libro {

    public function __construct(
        public string $isbn,
        public string $titulo,
        public string $autor,
        public string $materia){
    }

    public function __set($nombre, $valor) {
        if(property_exists($this, $nombre)) {
            $this->$nombre = $valor;
        }
    }

    public function __get($nombre) {
        if(property_exists($this, $nombre)){
            return $this->$nombre;
        }
    }

    public function toLine(){
        return($this->isbn."|".$this->titulo."|".$this->autor."|".$this->materia);
    }

    public static function lineToLibro($linea) {
        $cadena = explode("|",$linea);
        return new Libro($cadena[0],$cadena[1],$cadena[2],$cadena[3]);
    }
}
