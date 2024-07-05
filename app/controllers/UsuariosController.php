<?php

require_once 'config/Controller.php';

class UsuariosController extends Controller
{
    public function index()
    {
        $this->loadView('usuarios/index');
    }

    public function list()
    {
        $usuarioDAO = $this->loadModel('UsuarioDAO');

        $respuesta = $usuarioDAO->getAll();

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function create()
    {
        $this->loadView('usuarios/editar');
    }

    public function store()
    {
        $errores = $this->validarCampos($_POST);

        if ( !empty($errores) ) {
            $respuesta = [
                "success" => false,
                "message" => "ERROR: Campos obligatorios no llenados.",
                "errors" => $errores
            ];
        } else {
            $usuario = $this->loadModel('Usuario');
            $usuarioDAO = $this->loadModel('UsuarioDAO');

            $usuario->setNombre($_POST['nombre']);
            $usuario->setApellido($_POST['apellido']);
            $usuario->setDni($_POST['dni']);
            $usuario->setPassword($_POST['password']);
            $usuario->setEmail($_POST['email']);
            $usuario->setDireccion($_POST['direccion']);
            $usuario->setFechaCreacion( new DateTime() );
            $usuario->setFechaActualizacion( new DateTime() );
            $usuario->setPerfilesId($_POST['perfiles_id']);

            $respuesta = $usuarioDAO->create($usuario);
        }

        if ($respuesta['success']) {
            http_response_code(200);
        } else {
            http_response_code(500);
        }

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function edit(string $id)
    {
        $usuarioDAO = $this->loadModel('UsuarioDAO');
        $response = $usuarioDAO->getUsuario($id);

        if ($response['success']) {
            $usuario = $response['data'];

            $this->loadView('usuarios/editar', compact('usuario'));
        } else {
            $error = $response['message'];

            $this->loadView('usuarios/editar', compact('error'));
        }
    }

    public function update(string $id)
    {
        // Para obtener los datos que se enviaron en la peticion PUT
        $input = file_get_contents('php://input');
        parse_str($input, $request);
        
        // Validamos
        $errores = $this->validarCampos($request);

        if ( !empty($errores) ) {
            $respuesta = [
                "success" => false,
                "message" => "ERROR: Todos los campos son obligatorios",
                "errors" => $errores
            ];
        } else {
            $usuario = $this->loadModel('Usuario');
            $usuarioDAO = $this->loadModel('UsuarioDAO');

            $usuario->setId($request['id']);
            $usuario->setNombre($request['nombre']);
            $usuario->setApellido($request['apellido']);
            $usuario->setDni($request['dni']);
            $usuario->setPassword($request['password']);
            $usuario->setEmail($request['email']);
            $usuario->setDireccion($request['direccion']);
            $usuario->setFechaActualizacion(new DateTime()); // actualizamos la fecha de actualizacion
            $usuario->setPerfilesId($request['perfiles_id']);

            // Crear objeto Perfil si se envía desde el formulario
            if (isset($request['perfil_nombre']) && !empty($request['perfil_nombre'])) {
                $perfil = $this->loadModel('Perfil');
                $perfil->setNombre($request['perfil_nombre']);
                $usuario->setPerfil($perfil);
            }

            $respuesta = $usuarioDAO->update($usuario);
        }

        if ($respuesta['success']) {
            http_response_code(200);
        } else {
            http_response_code(500);
        }

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function destroy(string $id)
    {
        $usuarioDAO = $this->loadModel('UsuarioDAO');

        $respuesta = $usuarioDAO->delete($id);

        if ($respuesta['success']) {
            http_response_code(200);
        } else {
            http_response_code(500);
        }

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    // Validaermos los datos que vengan de post o con put
    private function validarCampos(array $data): array
    {
        // Campos obligatorios
        $camposObligatorios = ['nombre', 'apellido', 'dni', 'password', 'email', 'direccion', 'perfiles_id']; // la fecha de creacion y actualizacion la asignamos por defecto
        $errores = [];

        foreach($camposObligatorios as $campo) 
        {
            if ( !isset($data[$campo]) || empty($data[$campo]) )
            {
                $errores[] = "El campo {$campo} es obligatorio";
            }
        }

        return $errores;
    }
}