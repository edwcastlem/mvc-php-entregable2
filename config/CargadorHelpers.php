<?php

class CargadorHelpers {

    public static function loadHelper($helper, $parametros = [])
    {
        if (file_exists('app/helpers/' . $helper . '.php')) {
            // Extraemos los parametros pasados
            foreach (array_keys($parametros) as $key)
            {
                $$key = $parametros[$key];
            }
            require_once 'app/helpers/' . $helper . '.php';
        } else {
            die("404 NO ENCONTRADO");
        }
    }
    
}