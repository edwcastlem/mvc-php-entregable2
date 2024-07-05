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

    public function getPerfil(string $id)
    {
        $sql = "SELECT * FROM perfiles WHERE id = " . $id;
        $result = $this->conn->query($sql);

        $row = $result->fetch_assoc();

        if ($row) {
            $perfil = new Perfil();
            $perfil->setId($row['id']);
            $perfil->setNombre($row['nombre']);

            return [
                "success" => true,
                "data" => $perfil
            ];
        }

        return [
            "success" => false,
            "message" => "Perfil no encontrado"
        ];
    }

    // Obtenemos todos los perfiles
    public function getAll()
    {
        $sql = "SELECT * FROM perfiles";
        $result = $this->conn->query($sql);
        $perfiles = $result->fetch_all(MYSQLI_ASSOC); // asocia los nombres de los campos con su valor

        return [
            "success" => true,
            "data" => $perfiles
        ];
    }

    // Crear un perfil 
    public function create(Perfil $perfil)
    {
        $sql = "INSERT INTO perfiles (nombre) VALUES ('{$perfil->getNombre()}')";
        $query = mysqli_query($this->conn,  $sql);

        if ($query) {
            return [
                "success" => true,
                "message" => "Perfil creado exitosamente"
            ];
        } 
        else {
            return [
                "success" => false,
                "message" => "ERROR: Perfil no se creo"
            ];
        }
    }

    public function update(Perfil $perfil)
    {
        $sql = "UPDATE perfiles set nombre = '{$perfil->getNombre()}' where id = {$perfil->getId()}";
        $query = mysqli_query($this->conn, $sql);

        if ($query) {
            return [
                "success" => true,
                "message" => "Perfil actualizado exitosamente"
            ];
        } 
        else {
            return [
                "success" => false,
                "message" => "ERROR: Perfil no se pudo actualizar {mysqli_error($this->conn)}"
            ];
        }
    }

    public function delete(string $id)
    {
        $sql = "DELETE FROM perfiles WHERE id = {$id}";
        $query = mysqli_query($this->conn, $sql);

        if ($query) {
            return [
                "success" => true,
                "message" => "Se eliminó exitosamente"
            ];
        } 
        else {
            return [
                "success" => false,
                "message" => "ERROR: No se pudo eliminar"
            ];
        }
    }
}