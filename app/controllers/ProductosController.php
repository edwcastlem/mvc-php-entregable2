<?php

require_once 'config/Controller.php';
require_once 'app/helpers/LoginUtils.php';
require_once 'app/helpers/ValidarUtils.php';

class ProductosController extends Controller {

    private $camposObligatorios = [
        'codigo',
        'nombre',
        'descripcion',
        'moneda',
        'precio_compra',
        'precio_venta',
        'categorias_id',
        'proveedores_id'
    ];

    public function index()
    {
        LoginUtils::requiereLogin();
        $this->loadView('productos/index');
    }

    public function list()
    {
        LoginUtils::requiereLogin();

        $productoDAO = $this->loadModel('ProductoDAO');

        $respuesta = [
            "success" => true,
            "data" => $productoDAO->getAll()
        ];

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function create()
    {
        LoginUtils::requiereLogin();
        $this->loadView('productos/editar');
    }

    public function store()
    {
        LoginUtils::requiereLogin();

        $errores = ValidarUtils::camposObligatorios($this->camposObligatorios, $_POST);

        if (!empty($errores)) {
            $respuesta = [
                "success" => false,
                "message" => "ERROR: Campos obligatorios no llenados.",
                "errors" => $errores
            ];
        } else {
            $producto = $this->loadModel('Producto');
            $productoDAO = $this->loadModel('ProductoDAO');

            $producto->setCodigo($_POST['codigo']);
            $producto->setNombre($_POST['nombre']);
            $producto->setDescripcion($_POST['descripcion']);
            $producto->setMoneda($_POST['moneda']);
            $producto->setPrecioCompra($_POST['precio_compra']);
            $producto->setPrecioVenta($_POST['precio_venta']);
            
            // Asignamos la categoria
            $categoriaDAO = $this->loadModel('CategoriaDAO');
            $categoria = $categoriaDAO->getCategoria($_POST['categorias_id']);
            $producto->setCategoria($categoria);

            // Asignamos el proveedor
            $proveedorDAO = $this->loadModel('ProveedorDAO');
            $proveedor = $proveedorDAO->getProveedor($_POST['proveedores_id']);
            $producto->setProveedor($proveedor);

            // Asignamos el usuario actual
            $producto->setUsuario(LoginUtils::usuario());

            // Creamos el producto
            $result = $productoDAO->create($producto);

            // Generamos la respuesta
            if ($result === true) {
                $respuesta = [
                    "success" => true,
                    "message" => "Producto creado correctamente!"
                ];
            }
            else {
                $respuesta = [
                    "success" => false,
                    "message" => "No se pudo crear el producto! " . $result
                ];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function edit(string $id)
    {
        LoginUtils::requiereLogin();

        $productoDAO = $this->loadModel('ProductoDAO');
        $producto = $productoDAO->getProducto($id);

        if ($producto !== null) {
            $this->loadView('productos/editar', compact('producto'));
        } else {
            $error = "Producto no encontrado!!!";
            $this->loadView('productos/editar', compact('error'));
        }
    }

    public function show(string $id)
    {
        $productoDAO = $this->loadModel('ProductoDAO');
        $producto = $productoDAO->getProducto($id);

        if (!empty($producto)) {
            $this->loadView('/productos/show', compact('producto'));
        }
        else {
            $error = "No se encontró el producto";
            $this->loadView('error', compact('error'));
        }

    }

    public function update()
    {
        LoginUtils::requiereLogin();

        $input = file_get_contents('php://input');
        parse_str($input, $request);

        $errores = ValidarUtils::camposObligatorios($this->camposObligatorios, $request);

        if (!empty($errores)) {
            $respuesta = [
                "success" => false,
                "message" => "ERROR: No se pudo actualizar.",
                "errors" => $errores
            ];
        } else {
            $producto = $this->loadModel('Producto');
            $productoDAO = $this->loadModel('ProductoDAO');

            $producto->setId($request['id']);
            $producto->setCodigo($request['codigo']);
            $producto->setNombre($request['nombre']);
            $producto->setDescripcion($request['descripcion']);
            $producto->setMoneda($request['moneda']);
            $producto->setPrecioCompra($request['precio_compra']);
            $producto->setPrecioVenta($request['precio_venta']);
            
            // Asignamos la categoria
            $categoriaDAO = $this->loadModel('CategoriaDAO');
            $categoria = $categoriaDAO->getCategoria($request['categorias_id']);
            $producto->setCategoria($categoria);

            // Asignamos el proveedor
            $proveedorDAO = $this->loadModel('ProveedorDAO');
            $proveedor = $proveedorDAO->getProveedor($request['proveedores_id']);
            $producto->setProveedor($proveedor);

            // Actualizamos el usuario
            $producto->setUsuario(LoginUtils::usuario());

            $result = $productoDAO->update($producto);

            if ($result === true) {
                $respuesta = [
                    "success" => true,
                    "message" => "Proveedor actualizado con éxito"
                ];
            }
            else {
                $respuesta = [
                    "success" => false,
                    "message" => "ERROR: No se pudo actualizar el proveedor. {$result}"
                ];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function destroy(string $id)
    {
        LoginUtils::requiereLogin();

        $productoDAO = $this->loadModel('ProductoDAO');
        $result = $productoDAO->delete($id);

        if ($result === true) {
            $respuesta = [
                "success" => true,
                "message" => "Producto eliminado con éxito!!!"
            ];
        } else {
            $respuesta = [
                "success" => false,
                "message" => "ERROR: No se pudo eliminar el producto. {$result}"
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }
}