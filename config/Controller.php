<?php

/**
 * Clase para hacer que los controladores puedan cargar vistas o instanciar modelos
 * Todo controlador debe extender esta clase para tener esa funcionalidad
 */
class Controller
{
    public function loadModel($model)
    {
        if (file_exists('app/models/' . $model . '.php'))
        { 
            require_once 'app/models/' . $model . '.php';
            return new $model();
        } 
        else
        {
            die("CONTROLADOR NO ENCONTRADO");
        }
    }

    public function loadView($view, $parametros = [])
    {
        if (file_exists('app/views/' . $view . '.php'))
        {
            // Extraemos los parametros pasados a la vista
            foreach (array_keys($parametros) as $key)
            {
                $$key = $parametros[$key];
            }
            require_once 'app/views/' . $view . '.php';
        } 
        else 
        {
            die("VISTA NO ENCONTRADADA");
        }
    }
}