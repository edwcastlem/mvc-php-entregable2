<?php

// Verificamos el contenido del .htaccess para definir la carpeta raiz
$fileHtaccess = '.htaccess';
$server_url = '';

if (file_exists($fileHtaccess)) {
    $contenido = file_get_contents($fileHtaccess);

    // Expresión regular para encontrar la línea RewriteBase
    if (preg_match('/RewriteBase\s+(\/[^\s]*)/', $contenido, $matches)) {
        $server_url = $matches[1];
        $str_base_url = 'http://localhost' . $server_url;
        $base_url = substr($str_base_url, 0, strlen($str_base_url) - 1); // quitamos el ultimo /
        define('BASE_URL', $base_url);
    }
}

//echo "SERVER URL: " . $server_url;

$server_url = str_replace($server_url, '', $_SERVER['REQUEST_URI']);
$url = explode('/', $server_url);


/**
 * Verificamos las rutas
 * Formato de las rutas: perfiles/create
 * perfiles/edit/3
 * perfiles/delete/3
 */

//$url = explode("/", $_SERVER['REQUEST_URI']);


// Obtenemos el controlador de la url
$controlador = ( isset($url[0]) && !empty($url[0]) ) ? ucwords($url[0]) . 'Controller': 'PaginaController';

// Obtenemos el método
$metodo = ( isset($url[1]) && !empty($url[1]) ) ? strtolower($url[1]) : 'index';
// Limpiamos el nombre si hay un ?
$metodo = str_replace("?", "", $metodo);

// Obtenemos los parametros de la URL
$parametros = [];
if (isset($url[2]) && !empty($url[2])) {
    $parametros = array_slice($url, 2);
}

//  echo "SERVER URL: " . $server_url;
//  echo "BASE_URL: " . BASE_URL;
//  echo "Controlador: $controlador Método: $metodo";
//  echo "Parametros: " . print_r($parametros);
//  exit();


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