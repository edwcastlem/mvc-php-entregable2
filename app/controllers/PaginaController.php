<?php

require_once 'config/Controller.php';

class PaginaController extends Controller
{
    public function index()
    {
        $titulo = "HOLA DESDE CONTROLADOR";

        $this->loadView('index', ['titulo' => $titulo]);
    }
}
