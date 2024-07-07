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

        $row = $result->fetch_assoc();

        if ($row) {
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
        $sql = "INSERT INTO perfiles (nombre) VALUES ('{$perfil->getNombre()}')";
        $query = mysqli_query($this->conn,  $sql);

        return $query === false ? mysqli_error($this->conn) : true;
    }

    public function update(Perfil $perfil)
    {
        $sql = "UPDATE perfiles set nombre = '{$perfil->getNombre()}' where id = {$perfil->getId()}";
        $query = mysqli_query($this->conn, $sql);

        return $query === false ? mysqli_error($this->conn) : true;
    }

    public function delete(string $id)
    {
        $sql = "DELETE FROM perfiles WHERE id = {$id}";
        $query = mysqli_query($this->conn, $sql);

        return $query === false ? mysqli_error($this->conn) : true;
    }
}