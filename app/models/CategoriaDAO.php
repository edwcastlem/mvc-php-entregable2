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

        if ($result->num_rows == 1) {

            $row = $result->fetch_assoc();
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
        try {
            $sql = "INSERT INTO categorias (nombre) VALUES ('{$categoria->getNombre()}')";
            $result = mysqli_query($this->conn,  $sql);
    
            return $result;
        }
        catch (mysqli_sql_exception $e) {
            return ValidarUtils::msjErrorBD($e);
        }
    }

    public function update(Categoria $categoria)
    {
        try {
            $sql = "UPDATE categorias set nombre = '{$categoria->getNombre()}' where id = {$categoria->getId()}";
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
            $sql = "DELETE FROM categorias WHERE id = {$id}";
            $result = mysqli_query($this->conn, $sql);
    
            return $result;
        }
        catch (mysqli_sql_exception $e) {
            return ValidarUtils::msjErrorBD($e);
        }
    }
}