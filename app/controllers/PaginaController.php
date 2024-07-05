<?php

require_once 'config/Controller.php';

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
}
