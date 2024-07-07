<?php

require_once 'config/Controller.php';
require_once 'app/helpers/LoginUtils.php';
require_once 'app/helpers/ValidarUtils.php';

class LoginController extends Controller
{
    private $camposObligatorios = ['email', 'password'];

    public function index()
    {
        $this->loadView('login');
    }

    public function iniciar_sesion()
    {
        $usuarioDAO = $this->loadModel('UsuarioDAO');

        // Validamos el email y contraseña obligatorios
        $errores = ValidarUtils::camposObligatorios($this->camposObligatorios, $_POST);

        // Verificamos si hay errores
        if (empty($errores)) {
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            $usuario = $usuarioDAO->loginUsuario($email, $password);
    
            if ($usuario !== null) {
                session_start();
                $_SESSION['usuario'] = $usuario;
    
                $respuesta = [
                    "success" => true,
                    "message" => "Inicio correcto!!!"
                ];
            }
            else {
                $respuesta = [
                    "success" => false,
                    "message" => "Verifica email y contraseña"
                ];
            }
        }
        else {
            $respuesta = [
                "success" => false,
                "message" => "ERROR: Campos obligatorios no llenados.",
                "errors" => $errores
            ];
        }

        // Enviamos la respuesta
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function cerrar_sesion()
    {
        if (LoginUtils::estaLogueado()) 
        {
            session_destroy();
            header("Location: " . BASE_URL . "/login");
            exit;
        }
    }

    public function restablecer()
    {
        // Mostramos la vista restablecer
        $this->loadView('reset-pass');
    }

    public function verificar_email()
    {
        // Recibimos el email y verificamos si existe
        $email = $_POST['email'] ?? '';

        if ( empty($email) ) {
            $respuesta = [
                "success" => false,
                "message" => "ERROR: Ingresa el email."
            ];
        }
        else {
            $usuarioDAO = $this->loadModel('UsuarioDAO');
            $usuario = $usuarioDAO->getUsuarioByEmail($email);

            if ($usuario !== null) {
                // Guardamos el email en la sesion
                session_start();
                $_SESSION['email'] = $email;

                $respuesta = [
                    "success" => true,
                    "message" => "El email se encontro!!"
                ];
            }
            else {
                // mandamos respuesta con error
                $respuesta = [
                    "success" => false,
                    "message" => "El email no se ha encontrado!!"
                ];
            }
        }

        // Enviamos la respuesta
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function cambiar_contra()
    {
        session_start();
        $email = $_SESSION['email'];

        if (!$email) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
        session_destroy();

        $this->loadView('new-pass', compact('email'));
    }

    public function update_password()
    {
        // Recibimos las contraseñas para validarlas
        $password = $_POST['password'] ?? '';
        $confirmacion_password = $_POST['confirmacion_password'] ?? '';

        if ( !empty($password) && !empty($confirmacion_password) ) {
            // Verificamos si son iguales
            if ($password === $confirmacion_password) {
                // Traemos el email para buscar al usuario
                $email = $_POST['email'];
                $usuarioDAO = $this->loadModel('UsuarioDAO');
                $usuario = $usuarioDAO->getUsuarioByEmail($email);
                
                // Cambiamos la contraseña
                $usuario->setPassword(password_hash($password, PASSWORD_DEFAULT));
                $usuarioDAO->update($usuario);

                // Todo ok
                $respuesta = [
                    "success" => true,
                    "message" => "Contraseña actualizada!!!"
                ];
            }
            else {
                $respuesta = [
                    "success" => false,
                    "message" => "Las contraseñas no coinciden!!!"
                ];
            }
        }
        else {
            $respuesta = [
                "success" => true,
                "message" => "Las contrseñas son obligatorias!!!"
            ];
        }

        // Enviamos la respuesta
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }
}
