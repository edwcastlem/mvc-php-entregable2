<?php

require_once RAIZ . '/database/Conexion.php';
require_once 'Proveedor.php';

class ProveedorDAO
{
    private $conn;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->conn = $conexion->getConexion();
    }

    public function getProveedor(string $id): ?Proveedor
    {
        $sql = "SELECT * FROM proveedores WHERE id = " . $id;
        $result = $this->conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $proveedor = new Proveedor();
            $proveedor->setId($row['id']);
            $proveedor->setRuc($row['ruc']);
            $proveedor->setRazonSocial($row['razon_social']);
            $proveedor->setRepresentanteLegal($row['representante_legal']);
            $proveedor->setEmail($row['email']);
            $proveedor->setTelefono($row['telefono']);
            $proveedor->setCelular($row['celular']);
            $proveedor->setDireccion($row['direccion']);
            $proveedor->setCuentaBancaria($row['cuenta_bancaria']);
            $proveedor->setCuentaCci($row['cuenta_cci']);
            $proveedor->setBanco($row['banco']);
            $proveedor->setFechaCreacion(new DateTime($row['fecha_creacion']));
            $proveedor->setFechaActualizacion(new DateTime($row['fecha_actualizacion']));

            return $proveedor;
        }

        return null;
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM proveedores";
        $result = $this->conn->query($sql);
        $proveedores = $result->fetch_all(MYSQLI_ASSOC);

        return $proveedores;
    }

    public function getAllSelect(): array
    {
        $sql = "SELECT id, razon_social as nombre FROM proveedores";
        $result = $this->conn->query($sql);
        $proveedores = $result->fetch_all(MYSQLI_ASSOC);

        return $proveedores;
    }

    public function create(Proveedor $proveedor)
    {
        try {
            // Sintaxis heredoc para cadenas largas
            $sql = <<<CONSULTA
            INSERT INTO proveedores (ruc, razon_social, representante_legal, email, telefono, celular, direccion, 
            cuenta_bancaria, cuenta_cci, banco, fecha_creacion, fecha_actualizacion)
            VALUES ('{$proveedor->getRuc()}', '{$proveedor->getRazonSocial()}', '{$proveedor->getRepresentanteLegal()}', 
            '{$proveedor->getEmail()}', '{$proveedor->getTelefono()}', '{$proveedor->getCelular()}', 
            '{$proveedor->getDireccion()}', '{$proveedor->getCuentaBancaria()}', '{$proveedor->getCuentaCci()}', 
            '{$proveedor->getBanco()}', NOW(), NOW());
            CONSULTA;
            $result = mysqli_query($this->conn, $sql);

            return $result;
        } catch (mysqli_sql_exception $e) {
            return ValidarUtils::msjErrorBD($e);
        }
    }

    public function update(Proveedor $proveedor)
    {
        try {
            $sql = <<<CONSULTA
            UPDATE proveedores SET 
                ruc = '{$proveedor->getRuc()}', razon_social = '{$proveedor->getRazonSocial()}', 
                representante_legal = '{$proveedor->getRepresentanteLegal()}', 
                email = '{$proveedor->getEmail()}', telefono = '{$proveedor->getTelefono()}', 
                celular = '{$proveedor->getCelular()}', direccion = '{$proveedor->getDireccion()}', 
                cuenta_bancaria = '{$proveedor->getCuentaBancaria()}', cuenta_cci = '{$proveedor->getCuentaCci()}', 
                banco = '{$proveedor->getBanco()}', 
                fecha_actualizacion = NOW()
            WHERE id = {$proveedor->getId()};
            CONSULTA;
            $result = mysqli_query($this->conn, $sql);

            return $result;
        } catch (mysqli_sql_exception $e) {
            return ValidarUtils::msjErrorBD($e);
        }
    }

    public function delete(string $id)
    {
        try {
            $sql = "DELETE FROM proveedores WHERE id = {$id}";
            $result = mysqli_query($this->conn, $sql);

            return $result;
        } catch (mysqli_sql_exception $e) {
            return ValidarUtils::msjErrorBD($e);
        }
    }
}
