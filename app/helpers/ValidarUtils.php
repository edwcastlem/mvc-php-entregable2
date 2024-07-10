<?php

class ValidarUtils
{
    // Validaermos los datos que vengan de post o con put
    public static function camposObligatorios(array $camposObligatorios, array $data): array
    {
        $errores = [];

        foreach($camposObligatorios as $campo) 
        {
            if ( isset($data[$campo]) && empty($data[$campo]) )
            {
                $errores[] = "El campo {$campo} es obligatorio";
            }
        }

        return $errores;
    }

    public static function validarPrecioCompraventa(float $precioCompra, float $precioVenta): Array
    {
        $errores = [];

        if ($precioCompra >= $precioVenta) {
            $errores[] = "El precio de venta tiene que ser mayor que el precio de compra";
        }

        return $errores;
    }

    public static function validarDNI(string $dni): Array {
        $errores = [];
        if (strlen($dni) != 8 ) {
            $errores[] = "El DNI debe tener 8 caracteres!";
        }

        if (!is_numeric($dni)) {
            $errores[] = "El DNI no debe tener letras!";
        }

        return $errores;
    }

    // Reconocer errores de bd
    public static function msjErrorBD(mysqli_sql_exception $e)
    {
        switch ($e->getCode()) {
            case 1062: //
                return "Existe un valor duplicado en la base de datos.";
            case 1451: // Error de clave foránea
                return "Error de clave foránea. Hay registros que dependen de este valor.";
            default:
                return "Error con la BD. Codigo: " . $e->getCode();
        }
    }
}