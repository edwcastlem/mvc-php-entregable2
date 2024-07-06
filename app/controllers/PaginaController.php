<?php

require_once 'config/Controller.php';
require_once 'app/helpers/LoginUtils.php';

class PaginaController extends Controller
{
    public function index()
    {
        $this->loadView('index');
    }

    public function prueba()
    {
        $this->loadView('prueba_forms');
    }

    public function hola()
    {
        LoginUtils::requiereLogin();
        $this->loadView('hola');
    }
}
