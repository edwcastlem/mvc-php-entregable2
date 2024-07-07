<?php

class ValidarUtils
{
    // Validaermos los datos que vengan de post o con put
    public static function camposObligatorios(array $camposObligatorios, array $data): array
    {
        $errores = [];

        foreach($camposObligatorios as $campo) 
        {
            if ( !isset($data[$campo]) || empty($data[$campo]) )
            {
                $errores[] = "El campo {$campo} es obligatorio";
            }
        }

        return $errores;
    }
}