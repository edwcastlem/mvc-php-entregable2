<?php

function obtenerMenuActual()
{
    $url = explode("/", $_SERVER['REQUEST_URI']);

    if (isset($url[3])) {
        return BASE_URL . '/' . strtolower($url[3]);
    }
    return "/";
}
