<?php

require_once 'config/Controller.php';
require_once 'app/helpers/LoginUtils.php';
require_once 'app/helpers/ValidarUtils.php';

class PerfilesController extends Controller
{
    private $camposObligatorios = ['nombre'];

    public function index()
    {
        LoginUtils::requiereLogin();
        $this->loadView('perfiles/index');
    }

    public function list()
    {
        LoginUtils::requiereLogin();

        $perfilDAO = $this->loadModel('PerfilDAO');

        $respuesta = [
            "success" => true,
            "data" => $perfilDAO->getAll()
        ];

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function create()
    {
        LoginUtils::requiereLogin();
        $this->loadView('perfiles/editar');
    }

    /**
     * Recibe los valores del formulario, los valida y devuelve
     * una respuesta en formato json con el codigo http correcto
     */
    public function store()
    {
        LoginUtils::requiereLogin();

        $errores = ValidarUtils::camposObligatorios($this->camposObligatorios, $_POST);

        // Validamos...
        if ( !empty($errores) )
        {
            $respuesta = [
                "success" => false,
                "message" => "ERROR: Campos obligatorios no llenados.",
                "errors" => $errores
            ];
        }
        else
        {
            // Obtenemos los datos
            $perfil = $this->loadModel('Perfil');
            $perfilDAO = $this->loadModel('PerfilDAO');
            
            $perfil->setNombre($_POST['nombre']);
    
            $result = $perfilDAO->create($perfil);

            if ($result === true) {
                $respuesta = [
                    "success" => true,
                    "message" => "Perfil creado correctamente!"
                ];
            } else {
                $respuesta = [
                    "success" => false,
                    "message" => "No se pudo crear el perfil! " . $result 
                ];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function edit(string $id)
    {
        LoginUtils::requiereLogin();

        // Obtenemos el perfil con el id
        $perfilDAO = $this->loadModel('PerfilDAO');
        $perfil = $perfilDAO->getPerfil($id);

        // Validamos la respuesta del modelo
        if ($perfil !== null) { // si se crea el perfil sin problemas
            // Enviamos la respuesta a la vista
            $this->loadView('perfiles/editar', compact('perfil'));
        }
        else {
            $error = "Perfil no encontrado!!!";

            // Enviamos la respuesta a la vista
            $this->loadView('perfiles/editar', compact('error'));
        }
    }

    public function update()
    {
        LoginUtils::requiereLogin();

        // Validamos... vienen de un PUT
        $input = file_get_contents('php://input');

        // Parsear los datos del form
        parse_str($input, $request);

        // Validamos
        $errores = ValidarUtils::camposObligatorios($this->camposObligatorios, $request);

        if ( !empty($errores) )
        {
            $respuesta = [
                "success" => false,
                "message" => "ERROR: Campos obligatorios no llenados.",
                "errors" => $errores
            ];
        }
        else
        {
            // Obtenemos los datos
            $perfil = $this->loadModel('Perfil');
            $perfilDAO = $this->loadModel('PerfilDAO');
            
            $perfil->setId($request['id']);
            $perfil->setNombre($request['nombre']);
    
            $result = $perfilDAO->update($perfil);

            // Verificamos si la respuesta tiene un error para mandar un codigo adecuado
            if ($result === true)
            {
                $respuesta = [
                    "success" => true,
                    "message" => "Se actualizó con éxito"
                ];
            }
            else
            {
                $respuesta = [
                    "success" => false,
                    "message" => "ERROR: No se pudo actualizar con éxito. " . $result
                ];
            }
        }

        // Enviamos la respuesta
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function destroy(string $id)
    {
        LoginUtils::requiereLogin();

        $perfilDAO = $this->loadModel('PerfilDAO');

        $result = $perfilDAO->delete($id);

        // Verificamos si la respuesta tiene un error para mandar un codigo adecuado
        if ( $result === true )
        {
            $respuesta = [
                "success" => true,
                "message" => "Perfil eliminado con éxito!!!"
            ];
        }
        else
        {
            $respuesta = [
                "success" => false,
                "message" => "ERROR: No se pudo eliminar. {$result}"
            ];
        }

        // Enviamos la respuesta
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }
}
