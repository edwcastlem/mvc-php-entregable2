<?php

require_once 'config/Controller.php';
require_once 'app/helpers/LoginUtils.php';

class PerfilesController extends Controller
{
    public function index()
    {
        LoginUtils::requiereLogin();
        $this->loadView('perfiles/index');
    }

    public function list()
    {
        LoginUtils::requiereLogin();

        $perfilDAO = $this->loadModel('perfilDAO');

        $respuesta = $perfilDAO->getAll();

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

        // Validamos...
        if ( !isset($_POST['nombre']) || empty($_POST['nombre']) )
        {
            http_response_code(200);
        }
        else
        {
            // Obtenemos los datos
            $perfil = $this->loadModel('Perfil');
            $perfilDAO = $this->loadModel('PerfilDAO');
            
            $perfil->setNombre($_POST['nombre']);
    
            $respuesta = $perfilDAO->create($perfil);
        }
    
        // Verificamos si la respuesta tiene un error para mandar un codigo adecuado
        if ($respuesta['success'])
        {
            http_response_code(200); // codigo 200 OK
        }
        else
        {
            http_response_code(500); // codigo 500: error de servidor
        }

        // Enviamos la respuesta
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function edit(string $id)
    {
        LoginUtils::requiereLogin();

        // Obtenemos el perfil con el id
        $perfilDAO = $this->loadModel('perfilDAO');
        $response = $perfilDAO->getPerfil($id);

        // Validamos la respuesta del modelo
        if ($response['success']) { // si la respuesta esta ok
            $perfil = $response['data'];
            
            // Enviamos la respuesta a la vista
            $this->loadView('perfiles/editar', compact('perfil'));
        }
        else {
            $error = $response['message'];

            // Enviamos la respuesta a la vista
            $this->loadView('perfiles/editar', compact('error'));
        }
    }

    public function update(string $id)
    {
        LoginUtils::requiereLogin();

        // Validamos... vienen de un PUT
        $input = file_get_contents('php://input');

        //// Parsear los datos a formato json
        //$request = json_decode($input, true);

        // Parsear los datos del form
        parse_str($input, $request);

        if ( !isset($request['nombre']) || empty($request['nombre']) )
        {
            $respuesta = [
                "success" => false,
                "message" => "ERROR: Nombre obligatorio" . " . Desde el controller {$input}"
            ];
        }
        else
        {
            // Obtenemos los datos
            $perfil = $this->loadModel('Perfil');
            $perfilDAO = $this->loadModel('PerfilDAO');
            
            $perfil->setId($request['id']);
            $perfil->setNombre($request['nombre']);
    
            $respuesta = $perfilDAO->update($perfil);
        }
    
        // Verificamos si la respuesta tiene un error para mandar un codigo adecuado
        if ($respuesta['success'])
        {
            http_response_code(200); // codigo 200 OK
        }
        else
        {
            http_response_code(500); // codigo 500: error de servidor
        }

        // Enviamos la respuesta
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function destroy(string $id)
    {
        LoginUtils::requiereLogin();

        $perfilDAO = $this->loadModel('perfilDAO');

        $respuesta = $perfilDAO->delete($id);

        // Verificamos si la respuesta tiene un error para mandar un codigo adecuado
        if ($respuesta['success'])
        {
            http_response_code(200); // codigo 200 OK
        }
        else
        {
            http_response_code(500); // codigo 500: error de servidor
        }

        // Enviamos la respuesta
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }
}
