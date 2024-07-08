<?php

require_once 'config/Controller.php';
require_once 'app/helpers/LoginUtils.php';
require_once 'app/helpers/ValidarUtils.php';

class ProveedoresController extends Controller
{
    private $camposObligatorios = [
        'ruc',
        'razon_social',
        'representante_legal',
        'email',
        'telefono',
        'celular',
        'direccion',
        'cuenta_bancaria',
        'cuenta_cci',
        'banco'
    ];

    public function index()
    {
        LoginUtils::requiereLogin();
        $this->loadView('proveedores/index');
    }

    public function list()
    {
        LoginUtils::requiereLogin();

        $proveedorDAO = $this->loadModel('ProveedorDAO');

        $respuesta = [
            "success" => true,
            "data" => $proveedorDAO->getAll()
        ];

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function listSelect()
    {
        LoginUtils::requiereLogin();

        $proveedorDAO = $this->loadModel('ProveedorDAO');

        $respuesta = [
            "success" => true,
            "data" => $proveedorDAO->getAllSelect()
        ];

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function create()
    {
        LoginUtils::requiereLogin();
        $this->loadView('proveedores/editar');
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
            $proveedor = $this->loadModel('Proveedor');
            $proveedorDAO = $this->loadModel('ProveedorDAO');

            $proveedor->setRuc($_POST['ruc']);
            $proveedor->setRazonSocial($_POST['razon_social']);
            $proveedor->setRepresentanteLegal($_POST['representante_legal']);
            $proveedor->setEmail($_POST['email']);
            $proveedor->setTelefono($_POST['telefono']);
            $proveedor->setCelular($_POST['celular']);
            $proveedor->setDireccion($_POST['direccion']);
            $proveedor->setCuentaBancaria($_POST['cuenta_bancaria']);
            $proveedor->setCuentaCci($_POST['cuenta_cci']);
            $proveedor->setBanco($_POST['banco']);

            $result = $proveedorDAO->create($proveedor);

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

    public function edit(string $id)
    {
        LoginUtils::requiereLogin();

        $proveedorDAO = $this->loadModel('ProveedorDAO');
        $proveedor = $proveedorDAO->getProveedor($id);

        if ($proveedor !== null) {
            $this->loadView('proveedores/editar', compact('proveedor'));
        } else {
            $error = "Proveedor no encontrado!!!";
            $this->loadView('proveedores/editar', compact('error'));
        }
    }

    public function show(string $id)
    {
        $proveedorDAO = $this->loadModel('ProveedorDAO');
        $proveedor = $proveedorDAO->getProveedor($id);

        if (!empty($proveedor)) {
            $this->loadView('proveedores/show', compact('proveedor'));
        } else {
            $error = "No se encontro el proveedor!!!";

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
                "message" => "ERROR: No se pudo actualizar. {$errores}"
            ];
        } else {
            $proveedor = $this->loadModel('Proveedor');
            $proveedorDAO = $this->loadModel('ProveedorDAO');

            $proveedor->setId($request['id']);
            $proveedor->setRuc($request['ruc']);
            $proveedor->setRazonSocial($request['razon_social']);
            $proveedor->setRepresentanteLegal($request['representante_legal']);
            $proveedor->setEmail($request['email']);
            $proveedor->setTelefono($request['telefono']);
            $proveedor->setCelular($request['celular']);
            $proveedor->setDireccion($request['direccion']);
            $proveedor->setCuentaBancaria($request['cuenta_bancaria']);
            $proveedor->setCuentaCci($request['cuenta_cci']);
            $proveedor->setBanco($request['banco']);

            $result = $proveedorDAO->update($proveedor);

            if ($result === true) {
                $respuesta = [
                    "success" => true,
                    "message" => "Proveedor actualizado con éxito"
                ];
            } else {
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

        $proveedorDAO = $this->loadModel('ProveedorDAO');
        $result = $proveedorDAO->delete($id);

        if ($result === true) {
            $respuesta = [
                "success" => true,
                "message" => "Proveedor eliminado con éxito!!!"
            ];
        } else {
            $respuesta = [
                "success" => false,
                "message" => "ERROR: No se pudo eliminar el proveedor. {$result}"
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }
}