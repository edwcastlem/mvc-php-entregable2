<?php

require_once 'config/Controller.php';
require_once 'app/helpers/LoginUtils.php';
require_once 'app/helpers/ValidarUtils.php';

class CategoriasController extends Controller
{
    private $camposObligatorios = ['nombre'];

    public function index()
    {
        LoginUtils::requiereLogin();
        $this->loadView('categorias/index');
    }

    public function list()
    {
        LoginUtils::requiereLogin();

        $categoriaDAO = $this->loadModel('categoriaDAO');

        $respuesta = [
            "success" => true,
            "data" => $categoriaDAO->getAll()
        ];

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function create()
    {
        LoginUtils::requiereLogin();
        $this->loadView('categorias/editar');
    }

    /**
     * Recibe los valores del formulario, los valida y devuelve
     * una respuesta en formato json con el codigo http correcto
     */
    public function store()
    {
        LoginUtils::requiereLogin();

        $errores = ValidarUtils::camposObligatorios($this->camposObligatorios, $_POST);

        // Validamos...
        if ( !empty($errores) )
        {
            $respuesta = [
                "success" => false,
                "message" => "ERROR: Campos obligatorios no llenados.",
                "errors" => $errores
            ];
        }
        else
        {
            // Obtenemos los datos
            $categoria = $this->loadModel('Categoria');
            $categoriaDAO = $this->loadModel('CategoriaDAO');
            
            $categoria->setNombre($_POST['nombre']);
    
            $result = $categoriaDAO->create($categoria);
        }

        if ($result) {
            $respuesta = [
                "success" => true,
                "message" => "Categoría creada correctamente!"
            ];
        } else {
            $respuesta = [
                "success" => false,
                "message" => "No se pudo crear la categoría! " . $result 
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function edit(string $id)
    {
        LoginUtils::requiereLogin();

        // Obtenemos el perfil con el id
        $categoriaDAO = $this->loadModel('categoriaDAO');
        $categoria = $categoriaDAO->getCategoria($id);

        // Validamos la respuesta del modelo
        if ($categoria !== null) { // si se crea el perfil sin problemas
            // Enviamos la respuesta a la vista
            $this->loadView('categorias/editar', compact('categoria'));
        }
        else {
            $error = "Categoria no encontrada!!!";

            // Enviamos la respuesta a la vista
            $this->loadView('categorias/editar', compact('error'));
        }
    }

    public function update()
    {
        LoginUtils::requiereLogin();

        // Validamos... vienen de un PUT
        $input = file_get_contents('php://input');

        // Parsear los datos del form
        parse_str($input, $request);

        // Validamos
        $errores = ValidarUtils::camposObligatorios($this->camposObligatorios, $request);

        if ( !empty($errores) )
        {
            $respuesta = [
                "success" => false,
                "message" => "ERROR: No se puedo actualizar. {$errores}"
            ];
        }
        else
        {
            // Obtenemos los datos
            $categoria = $this->loadModel('Categoria');
            $categoriaDAO = $this->loadModel('CategoriaDAO');
            
            $categoria->setId($request['id']);
            $categoria->setNombre($request['nombre']);
    
            $result = $categoriaDAO->update($categoria);
        }
    
        // Verificamos si la respuesta tiene un error para mandar un codigo adecuado
        if ($result)
        {
            $respuesta = [
                "success" => true,
                "message" => "Se actualizó con éxito"
            ];
        }
        else
        {
            $respuesta = [
                "success" => false,
                "message" => "ERROR: No se pudo actualizar con éxito!!"
            ];
        }

        // Enviamos la respuesta
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    public function destroy(string $id)
    {
        LoginUtils::requiereLogin();

        $categoriaDAO = $this->loadModel('CategoriaDAO');

        $result = $categoriaDAO->delete($id);

        // Verificamos si la respuesta tiene un error para mandar un codigo adecuado
        if ( $result )
        {
            $respuesta = [
                "success" => true,
                "message" => "Categoria eliminado con éxito!!!"
            ];
        }
        else
        {
            $respuesta = [
                "success" => false,
                "message" => "ERROR: No se pudo eliminar. {$result}"
            ];
        }

        // Enviamos la respuesta
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }
}
