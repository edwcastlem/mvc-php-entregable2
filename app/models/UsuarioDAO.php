<?php

require_once RAIZ . '/database/Conexion.php';
require_once 'Usuario.php';

class UsuarioDAO
{
    private $conn;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->conn = $conexion->getConexion();
    }

    public function getUsuario(int $id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = {$id}";
        $result = $this->conn->query($sql);

        $row = $result->fetch_assoc();

        if ($row) {
            $usuario = new Usuario();
            $usuario->setId($row['id']);
            $usuario->setNombre($row['nombre']);
            $usuario->setApellido($row['apellido']);
            $usuario->setDni($row['dni']);
            $usuario->setPassword($row['password']);
            $usuario->setEmail($row['email']);
            $usuario->setDireccion($row['direccion']);
            $usuario->setFechaCreacion(new DateTime($row['fecha_creacion']));
            $usuario->setFechaActualizacion(new DateTime($row['fecha_actualizacion']));
            $usuario->setPerfilesId($row['perfiles_id']);

            return [
                "success" => true,
                "data" => $usuario
            ];
        }

        return [
            "success" => false,
            "message" => "Usuario no encontrado"
        ];
    }

    public function getAll()
    {
        $sql = "SELECT * FROM listar_usuarios"; // llamamos a la vista
        $result = $this->conn->query($sql);
        $usuarios = $result->fetch_all(MYSQLI_ASSOC);

        return [
            "success" => true,
            "data" => $usuarios
        ];
    }

    public function create(Usuario $usuario)
    {
        $sql = "INSERT INTO usuarios (nombre, apellido, dni, password, email, direccion, fecha_creacion, fecha_actualizacion, perfiles_id) 
                VALUES ('{$usuario->getNombre()}', '{$usuario->getApellido()}', '{$usuario->getDni()}', '{$usuario->getPassword()}' ,'{$usuario->getEmail()}',
                        '{$usuario->getDireccion()}', NOW(), NOW(), {$usuario->getPerfilesId()})";
        $query = mysqli_query($this->conn, $sql);

        if ($query) {
            return [
                "success" => true,
                "message" => "Usuario creado exitosamente"
            ];
        } else {
            return [
                "success" => false,
                "message" => "Error al crear usuario: " . mysqli_error($this->conn)
            ];
        }
    }

    public function update(Usuario $usuario)
    {
        $sql = "UPDATE usuarios SET 
                nombre = '{$usuario->getNombre()}',
                apellido = '{$usuario->getApellido()}',
                dni = '{$usuario->getDni()}',
                password = '{$usuario->getPassword()}',
                email = '{$usuario->getEmail()}',
                direccion = '{$usuario->getDireccion()}',
                fecha_actualizacion = NOW(),
                perfiles_id = {$usuario->getPerfilesId()}
                WHERE id = {$usuario->getId()}";
        
        $query = mysqli_query($this->conn, $sql);

        if ($query) {
            return [
                "success" => true,
                "message" => "Usuario actualizado exitosamente"
            ];
        } else {
            return [
                "success" => false,
                "message" => "Error al actualizar usuario: " . mysqli_error($this->conn)
            ];
        }
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM usuarios WHERE id = {$id}";
        $query = mysqli_query($this->conn, $sql);

        if ($query) {
            return [
                "success" => true,
                "message" => "Usuario eliminado exitosamente"
            ];
        } else {
            return [
                "success" => false,
                "message" => "Error al eliminar usuario: " . mysqli_error($this->conn)
            ];
        }
    }
}