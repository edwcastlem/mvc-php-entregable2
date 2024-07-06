<?php

class LoginUtils
{
    public static function estaLogueado()
    {
        require_once APP . '/models/Usuario.php';

        // Verificamos si la sesión existe
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Verificamos el objeto usuario de la sesión    
        if (isset($_SESSION['usuario'])) {
            return true;
        }

        return false;
    }

    public static function requiereLogin()
    {
        if (!LoginUtils::estaLogueado())
        {
            header("Location: " . BASE_URL . "/login");
            exit;
        }
    }

    public static function usuario()
    {
        if ( LoginUtils::estaLogueado() ) {
            return $_SESSION['usuario'];
        }
        return null;
    }
}