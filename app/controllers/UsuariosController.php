<?php

require_once 'config/Controller.php';
require_once 'app/helpers/ValidarUtils.php';
require_once 'app/helpers/LoginUtils.php';

class UsuariosController extends Controller
{
    private $camposObligatorios = ['nombre', 'apellido', 'dni', 'email', 'direccion', 'perfiles_id'];

    public function index()
    {
        LoginUtils::requiereLogin();
        $this->loadView('usuarios/index');
    }

    public function list()
    {
        LoginUtils::requiereLogin();
        $usuarioDAO = $this->loadModel('UsuarioDAO');

        $respuesta = [
            "success" => true,
            "data" => $usuarioDAO->getAll()
        ];
        
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function create()
    {
        LoginUtils::requiereLogin();
        $this->loadView('usuarios/editar');
    }

    public function store()
    {
        LoginUtils::requiereLogin();

        $camposObligatorios = ['nombre', 'apellido', 'dni', 'email', 'direccion', 'perfiles_id', 'password', 'confirmacion_password'];

        $errores = ValidarUtils::camposObligatorios($camposObligatorios, $_POST);

        if ( !empty($errores) ) {
            $respuesta = [
                "success" => false,
                "message" => "ERROR: Campos obligatorios no llenados.",
                "errors" => $errores
            ];
        } else {

            // Verificamos si se coinciden las contraseñas
            if ($_POST['password'] != $_POST['confirmacion_password']) {
                $respuesta = [
                    "success" => false,
                    "message" => "ERROR: Las contraseñas deben ser iguales.",
                ];
            }
            else {
                $usuario = $this->loadModel('Usuario');
                $usuarioDAO = $this->loadModel('UsuarioDAO');
    
                $usuario->setNombre($_POST['nombre']);
                $usuario->setApellido($_POST['apellido']);
                $usuario->setDni($_POST['dni']);
                // Encriptamos la contraseña
                $usuario->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
                $usuario->setEmail($_POST['email']);
                $usuario->setDireccion($_POST['direccion']);
                $usuario->setFechaCreacion( new DateTime() );
                $usuario->setFechaActualizacion( new DateTime() );
                $usuario->setPerfilesId($_POST['perfiles_id']);
    
                $result = $usuarioDAO->create($usuario);

                if ($result === true) {
                    $respuesta = [
                        "success" => true,
                        "message" => "Usuario creado correctamente!"
                    ];
                } else {
                    $respuesta = [
                        "success" => false,
                        "message" => "No se pudo crear el usuario! " . $result
                    ];
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function edit(string $id)
    {
        LoginUtils::requiereLogin();
        $usuarioDAO = $this->loadModel('UsuarioDAO');
        $usuario = $usuarioDAO->getUsuario($id);

        if ($usuario !== null) {
            $this->loadView('usuarios/editar', compact('usuario'));
        } else {
            $error = "No se encontro el usuario!!!";

            $this->loadView('usuarios/editar', compact('error'));
        }
    }

    public function show(string $id)
    {
        LoginUtils::requiereLogin();
        $usuarioDAO = $this->loadModel('UsuarioDAO');
        $usuario = $usuarioDAO->getUsuario($id);

        if (!empty($usuario)) {
            $this->loadView('usuarios/show', compact('usuario'));
        } else {
            $error = "No se encontro el usuario!!!";

            $this->loadView('error', compact('error'));
        }
    }

    // No se permitirá editar la contraseña
    public function update()
    {
        LoginUtils::requiereLogin();
        
        // Para obtener los datos que se enviaron en la peticion PUT
        $input = file_get_contents('php://input');
        parse_str($input, $request);
        
        // Validamos
        $errores = ValidarUtils::camposObligatorios($this->camposObligatorios, $request);

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
            
            //$usuario->setPassword($request['password']);
            $usuario->setEmail($request['email']);
            $usuario->setDireccion($request['direccion']);
            $usuario->setFechaActualizacion(new DateTime()); // actualizamos la fecha de actualizacion
            $usuario->setPerfilesId($request['perfiles_id']);

            // Recuperamos el id del perfil
            $perfilDAO = new PerfilDAO();
            $usuario->setPerfil($perfilDAO->getPerfil($usuario->getPerfilesId()));
            
            $result = $usuarioDAO->update($usuario);

            // Generamos la respuesta
            if ($result === true) {
                // actualizamos el usuario de la sesión
                $_SESSION['usuario'] = $usuario;
                
                $respuesta = [
                    "success" => true,
                    "message" => "Se actualizó correctamente al usuario"
                ];
            } else {
                $respuesta = [
                    "success" => true,
                    "message" => "ERROR: No se pudo actualizar. {$result}"
                ];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function destroy(string $id)
    {
        // Verificamos si el usuario esta previamente logueado, sino redirigimos
        LoginUtils::requiereLogin();
        
        // No se permite eliminar al usuario logueado
        if (LoginUtils::usuario()->getId() == $id) {
            $respuesta = [
                "success" => false,
                "message" => "ERROR: No se puede eliminar al usuario actual!!!"
            ];
        }
        else {
            $usuarioDAO = $this->loadModel('UsuarioDAO');
    
            $result = $usuarioDAO->delete($id);
    
            if ($result === true) {
                $respuesta = [
                    "success" => true,
                    "message" => "Usuario eliminado con éxito!!!"
                ];
            } else {
                $respuesta = [
                    "success" => false,
                    "message" => "ERROR: No se pudo eliminar. {$result}"
                ];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }
}