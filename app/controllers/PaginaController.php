<?php

require_once 'config/Controller.php';
require_once 'app/helpers/LoginUtils.php';

class PaginaController extends Controller
{
    public function index()
    {
        $this->loadView('index');
    }
    public function cargarData()
    {
        // Datos de prueba
        require_once 'database/cargardata.php';
    }
}
