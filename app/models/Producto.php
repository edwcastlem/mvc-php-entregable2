<?php

require_once 'Categoria.php';
require_once 'Proveedor.php';
require_once 'Usuario.php';

class Producto {
    private int $id;
    // private int $categorias_id;
    // private int $proveedores_id;
    private string $codigo;
    private string $nombre;
    private string $descripcion;
    private string $moneda;
    private float $precio_compra;
    private float $precio_venta;
    private DateTime $fecha_creacion;
    private DateTime $fecha_actualizacion;
    // private int $usuarios_id;

    private Categoria $categoria;
    private Proveedor $proveedor;
    private Usuario $usuario;


    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    // public function getCategoriasId(): int {
    //     return $this->categorias_id;
    // }

    // public function setCategoriasId(int $categorias_id): void {
    //     $this->categorias_id = $categorias_id;
    // }

    // public function getProveedoresId(): int {
    //     return $this->proveedores_id;
    // }

    // public function setProveedoresId(int $proveedores_id): void {
    //     $this->proveedores_id = $proveedores_id;
    // }

    public function getCodigo(): string {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): void {
        $this->codigo = $codigo;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function getDescripcion(): string {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void {
        $this->descripcion = $descripcion;
    }

    public function getMoneda(): string {
        return $this->moneda;
    }

    public function setMoneda(string $moneda): void {
        $this->moneda = $moneda;
    }

    public function getPrecioCompra(): float {
        return $this->precio_compra;
    }

    public function setPrecioCompra(float $precio_compra): void {
        $this->precio_compra = $precio_compra;
    }

    public function getPrecioVenta(): float {
        return $this->precio_venta;
    }

    public function setPrecioVenta(float $precio_venta): void {
        $this->precio_venta = $precio_venta;
    }

    public function getFechaCreacion(): DateTime {
        return $this->fecha_creacion;
    }

    public function setFechaCreacion(DateTime $fecha_creacion): void {
        $this->fecha_creacion = $fecha_creacion;
    }

    public function getFechaActualizacion(): DateTime {
        return $this->fecha_actualizacion;
    }

    public function setFechaActualizacion(DateTime $fecha_actualizacion): void {
        $this->fecha_actualizacion = $fecha_actualizacion;
    }

    // public function getUsuariosId(): int {
    //     return $this->usuarios_id;
    // }

    // public function setUsuariosId(int $usuarios_id): void {
    //     $this->usuarios_id = $usuarios_id;
    // }

    public function getCategoria(): Categoria {
        return $this->categoria;
    }

    public function setCategoria(Categoria $categoria): void {
        $this->categoria = $categoria;
    }

    public function getProveedor(): Proveedor {
        return $this->proveedor;
    }

    public function setProveedor(Proveedor $proveedor): void {
        $this->proveedor = $proveedor;
    }

    public function getUsuario(): Usuario {
        return $this->usuario;
    }

    public function setUsuario(Usuario $usuario): void {
        $this->usuario = $usuario;
    }
}