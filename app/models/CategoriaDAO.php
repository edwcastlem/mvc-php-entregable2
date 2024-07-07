<?php

require_once RAIZ . '/database/Conexion.php';
require_once 'Categoria.php';

class CategoriaDAO
{
    private $conn;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->conn = $conexion->getConexion();
    }

    public function getCategoria(string $id): ?Categoria
    {
        $sql = "SELECT * FROM categorias WHERE id = " . $id;
        $result = $this->conn->query($sql);

        $row = $result->fetch_assoc();

        if ($row) {
            $categoria = new Categoria();
            $categoria->setId($row['id']);
            $categoria->setNombre($row['nombre']);

            return $categoria;
        }

        return null;
    }

    // Obtenemos todas las categorias
    public function getAll()
    {
        $sql = "SELECT * FROM categorias";
        $result = $this->conn->query($sql);
        $categoria = $result->fetch_all(MYSQLI_ASSOC); // asocia los nombres de los campos con su valor

        return $categoria;
    }

    // Crear una categoria 
    public function create(Categoria $categoria)
    {
        $sql = "INSERT INTO categorias (nombre) VALUES ('{$categoria->getNombre()}')";
        $query = mysqli_query($this->conn,  $sql);

        return $query === false ? mysqli_error($this->conn) : true;
    }

    public function update(Categoria $categoria)
    {
        $sql = "UPDATE categorias set nombre = '{$categoria->getNombre()}' where id = {$categoria->getId()}";
        $query = mysqli_query($this->conn, $sql);

        return $query === false ? mysqli_error($this->conn) : true;
    }

    public function delete(string $id)
    {
        $sql = "DELETE FROM categorias WHERE id = {$id}";
        $query = mysqli_query($this->conn, $sql);

        return $query === false ? mysqli_error($this->conn) : true;
    }
}