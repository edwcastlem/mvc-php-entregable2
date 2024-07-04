<?php

/**
 * Verificamos las rutas
 * Formato de las rutas: perfiles/create
 * perfiles/edit/5
 * perfiles/delete/5
 */

$url = explode("/", $_SERVER['REQUEST_URI']);


// Obtenemos el controlador de la url
$controlador = ( isset($url[3]) && !empty($url[3]) ) ? ucwords($url[3]) . 'Controller': 'PaginaController';

// Obtenemos el método
$metodo = ( isset($url[4]) && !empty($url[4]) ) ? strtolower($url[4]) : 'index';
// Limpiamos el nombre si hay un ?
$metodo = str_replace("?", "", $metodo);

// Obtenemos los parametros de la URL
$parametros = [];
if (isset($url[5]) && !empty($url[5])) {
    $parametros = array_slice($url, 5);
}


// echo "Controlador: $controlador Método: $metodo";
// echo "Parametros: " . print_r($parametros);


require_once 'config/constantes.php'; 
require_once 'config/CargadorHelpers.php'; 

// verificamos que exista el controlador

if ( !file_exists('app/controllers/' . $controlador . '.php') ) 
{
    $controlador = "PaginaController";
    echo "NO EXISTE EL CONTROLADOR!!!";
}

require_once 'app/controllers/' . $controlador . '.php';

$objController = new $controlador();

if (method_exists($objController, $metodo)) {
    call_user_func_array([$objController, $metodo], $parametros);
} else {
    echo "Controlador: $controlador   Metodo: $metodo   Método no encontrado.";
}



// echo "Controlador: $controlador Método: $metodo";
// echo "Parametros: " . print_r($parametros);