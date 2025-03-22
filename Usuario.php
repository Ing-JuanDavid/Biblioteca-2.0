<?php
class Usuario {
    public function __construct(
        public int $id,
        public string $nombre,
        public int $telefono){
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
        return($this->id."|".$this->nombre."|".$this->telefono);
    }


    public static function lineToUsuario($linea) {
        $cadena = explode("|",$linea);
        return new Usuario(((int)$cadena[0]),$cadena[1],((int)$cadena[2]));
    }
}


