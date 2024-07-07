<?php

require_once RAIZ . '/database/Conexion.php';
require_once 'Usuario.php';
require_once 'PerfilDAO.php';

class UsuarioDAO
{
    private $conn;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->conn = $conexion->getConexion();
    }

    public function getUsuario(int $id): ?Usuario
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
            
            // Recuperamos el id del perfil
            $perfilDAO = new PerfilDAO();
            $usuario->setPerfil($perfilDAO->getPerfil($row['perfiles_id']));

            return $usuario;
        }

        return null;
    }

    public function getUsuarioByEmail(string $email): ?Usuario // puede devolver un obj usuario o null
    {
        $sql = "SELECT * FROM usuarios WHERE email = '{$email}'";
        $result = $this->conn->query($sql);

        if ($result->num_rows == 1) { // encuentra el usuario
            $row = $result->fetch_assoc();

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
            
            // Recuperamos el id del perfil
            $perfilDAO = new PerfilDAO();
            $usuario->setPerfil($perfilDAO->getPerfil($row['perfiles_id']));

            return $usuario;
        }

        return null;
    }

    public function loginUsuario(string $email, string $password): ?Usuario
    {
        $usuario = $this->getUsuarioByEmail($email);

        // Si el usuario existe
        if ($usuario !== null) {
            // Verificamos el password encriptado
            if ( password_verify($password, $usuario->getPassword()) ) {
                return $usuario;
            }
            else {
                return null;
            }
        }
        else { // No existe el email del usuario
            return null;
        }
    }

    public function getAll()
    {
        $sql = "SELECT * FROM listar_usuarios"; // llamamos a la vista
        $result = $this->conn->query($sql);
        $usuarios = $result->fetch_all(MYSQLI_ASSOC);

        return $usuarios;
    }

    public function create(Usuario $usuario)
    {
        $sql = "INSERT INTO usuarios (nombre, apellido, dni, password, email, direccion, fecha_creacion, fecha_actualizacion, perfiles_id) 
                VALUES ('{$usuario->getNombre()}', '{$usuario->getApellido()}', '{$usuario->getDni()}', '{$usuario->getPassword()}' ,'{$usuario->getEmail()}',
                        '{$usuario->getDireccion()}', NOW(), NOW(), {$usuario->getPerfilesId()})";
        $query = mysqli_query($this->conn, $sql);

        return $query === false ? mysqli_error($this->conn) : true;
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

        return $query === false ? mysqli_error($this->conn) : true;
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM usuarios WHERE id = {$id}";
        $query = mysqli_query($this->conn, $sql);

        return $query === false ? mysqli_error($this->conn) : true;
    }
}
