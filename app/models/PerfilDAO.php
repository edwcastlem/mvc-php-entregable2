<?php

require_once RAIZ . '/database/Conexion.php';
require_once 'Perfil.php';

class PerfilDAO
{
    private $conn;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->conn = $conexion->getConexion();
    }

    public function getPerfil(string $id): ?Perfil
    {
        $sql = "SELECT * FROM perfiles WHERE id = " . $id;
        $result = $this->conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
    
            $perfil = new Perfil();
            $perfil->setId($row['id']);
            $perfil->setNombre($row['nombre']);

            return $perfil;
        }

        return null;
    }

    // Obtenemos todos los perfiles
    public function getAll()
    {
        $sql = "SELECT * FROM perfiles";
        $result = $this->conn->query($sql);
        $perfiles = $result->fetch_all(MYSQLI_ASSOC); // asocia los nombres de los campos con su valor

        return $perfiles;
    }

    // Crear un perfil 
    public function create(Perfil $perfil)
    {
        try {
            $sql = "INSERT INTO perfiles (nombre) VALUES ('{$perfil->getNombre()}')";
            $result = mysqli_query($this->conn,  $sql);
    
            return $result;
        }
        catch (mysqli_sql_exception $e) {
            return ValidarUtils::msjErrorBD($e);
        }
    }

    public function update(Perfil $perfil)
    {
        try {
            $sql = "UPDATE perfiles set nombre = '{$perfil->getNombre()}' where id = {$perfil->getId()}";
            $result = mysqli_query($this->conn, $sql);

            return $result;
        }
        catch (mysqli_sql_exception $e) {
            return ValidarUtils::msjErrorBD($e);
        }
    }

    public function delete(string $id)
    {
        try {
            $sql = "DELETE FROM perfiles WHERE id = {$id}";
            $result = mysqli_query($this->conn, $sql);
    
            return $result; // Devuelve true o false
        }
        catch (mysqli_sql_exception $e) {
            return ValidarUtils::msjErrorBD($e);
        }
    }
}