<?php

require_once 'config/Controller.php';
require_once 'app/helpers/LoginUtils.php';

class LoginController extends Controller
{
    public function index()
    {
        $this->loadView('login');
    }

    public function iniciar_sesion()
    {
        $usuarioDAO = $this->loadModel('UsuarioDAO');

        // Recibimos datos de la vista
        $email = $_POST['email'];
        $password = $_POST['password'];

        $resultado = $usuarioDAO->loginUsuario($email, $password);

        $usuario = null;

        if ($resultado['success']) {
            session_start();
            $usuario = $resultado['data'];
            $_SESSION['usuario'] = $usuario;

            http_response_code(200);
        } else {
            http_response_code(500); // codigo 500: error de servidor
        }

        // Enviamos la respuesta
        header('Content-Type: application/json');
        echo json_encode($resultado);
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
}
