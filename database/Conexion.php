<?php

class Conexion
{
    private $conn;

    public function getConexion()
    {
        // automaticamente se pueden usar las constantes definidas en el archivo constantes.php
        $this->conn = new mysqli(HOST, USER, PASSWORD, BD);

        if ($this->conn->connect_error) {
            die('Error de conexion: ' . $this->conn->connect_error);
        }
        else{
            //echo "Conexión exitosa!!!!";
            return $this->conn;
        }
    }
}