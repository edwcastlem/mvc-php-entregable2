<?php

require_once RAIZ . '/database/Conexion.php';
require_once 'Producto.php';
require_once 'UsuarioDAO.php';
require_once 'ProveedorDAO.php';
require_once 'CategoriaDAO.php';

class ProductoDAO
{
    private $conn;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->conn = $conexion->getConexion();
    }

    public function getProducto(string $id): ?Producto
    {
        $sql = "SELECT * FROM productos WHERE id = " . $id;
        $result = $this->conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $producto = new Producto();
            $producto->setId($row['id']);
            $producto->setCodigo($row['codigo']);
            $producto->setNombre($row['nombre']);
            $producto->setDescripcion($row['descripcion']);
            $producto->setMoneda($row['moneda']);
            $producto->setPrecioCompra($row['precio_compra']);
            $producto->setPrecioVenta($row['precio_venta']);
            $producto->setFechaCreacion(new DateTime($row['fecha_creacion']));
            $producto->setFechaActualizacion(new DateTime($row['fecha_actualizacion']));

            // Seteamos el Usuario
            $usuarioDAO = new UsuarioDAO();
            $producto->setUsuario($usuarioDAO->getUsuario($row['usuarios_id']));

            // Seteamos el proveedor
            $proveedorDAO = new ProveedorDAO();
            $producto->setProveedor($proveedorDAO->getProveedor($row['proveedores_id']));

            // Seteamos la categoria
            $categoriaDAO = new CategoriaDAO();
            $producto->setCategoria($categoriaDAO->getCategoria($row['categorias_id']));

            return $producto;
        }

        return null;
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM listar_productos";
        $result = $this->conn->query($sql);
        $productos = $result->fetch_all(MYSQLI_ASSOC);

        return $productos;
    }

    public function create(Producto $producto)
    {
        try {
            // Sintaxis heredoc para cadenas largas
            $sql = <<<CONSULTA
            INSERT INTO productos (codigo, nombre, descripcion, moneda, precio_compra, precio_venta, fecha_creacion, 
            fecha_actualizacion, categorias_id, proveedores_id, usuarios_id)
            VALUES ('{$producto->getCodigo()}', '{$producto->getNombre()}', '{$producto->getDescripcion()}', 
            '{$producto->getMoneda()}', '{$producto->getPrecioCompra()}', '{$producto->getPrecioVenta()}', 
            NOW(), NOW(), {$producto->getCategoria()->getId()}, {$producto->getProveedor()->getId()},
            {$producto->getUsuario()->getId()});
            CONSULTA;
            $result = mysqli_query($this->conn, $sql);

            return $result;
        } catch (mysqli_sql_exception $e) {
            return ValidarUtils::msjErrorBD($e);
        }
    }

    public function update(Producto $producto)
    {
        try {
            $sql = <<<CONSULTA
            UPDATE productos SET 
                codigo = '{$producto->getCodigo()}', nombre = '{$producto->getNombre()}', 
                descripcion = '{$producto->getDescripcion()}', moneda = '{$producto->getMoneda()}', 
                precio_compra = {$producto->getPrecioCompra()}, precio_venta = {$producto->getPrecioVenta()},
                fecha_actualizacion = NOW(), categorias_id = {$producto->getCategoria()->getId()},
                proveedores_id = {$producto->getProveedor()->getId()}, usuarios_id = {$producto->getUsuario()->getId()}
            WHERE id = {$producto->getId()};
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
            $sql = "DELETE FROM productos WHERE id = {$id}";
            $result = mysqli_query($this->conn, $sql);

            return $result;
        } catch (mysqli_sql_exception $e) {
            return ValidarUtils::msjErrorBD($e);
        }
    }
}
