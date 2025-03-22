<?php
class Prestamo {
    public function __construct(
        public int $id,
        public int $idUsuario,
        public string $isbn,
        public string $fecha){
    }

    // magic set y get
    public function __set($name, $value) {
        if(property_exists($this, $name)) {
            $this->$name = $value;
        }
    }

    public function __get($name) {
        if(property_exists($this, $name)){
            return $this->$name;
        }
    }

    public function toLine(){
        return($this->id."|".$this->idUsuario."|".$this->isbn."|".$this->fecha);
    }


    public static function lineToPrestamo($linea) {
        $cadena = explode("|",$linea);
        return new Prestamo(((int)$cadena[0]),((int)$cadena[1]),$cadena[2],$cadena[3]);
    }
}