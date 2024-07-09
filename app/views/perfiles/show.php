<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo ?? 'SISTEMA DE GESTIÓN' ?></title>
    <?php require_once APP . '/views/layouts/head.php' ?>
</head>

<body class="bg-gray-100">
    <?php require_once APP . '/views/layouts/header.php' ?>
    <main class="flex-grow flex items-center justify-center p-4 w-full max-w-screen-xl mx-auto">
        <div class="bg-white p-6 rounded shadow-md w-full">
            <h2 class="text-xl mb-4">
                Perfil: <?php echo $perfil->getNombre() ?>
            </h2>
            <p class="my-4">Usuarios con este perfil: <?php echo count($usuarios) ?></p>
            <?php if( count($usuarios) > 0) { ?>
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nombre</th>
                        <th scope="col" class="px-6 py-3">Apellido</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Dni</th>
                        <th scope="col" class="px-6 py-3">Fecha de Creación</th>
                        <th scope="col" class="px-6 py-3">Fecha de Actualizacion</th>
                        <th scope="col" class="px-6 py-3">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($usuarios as $usuario) { ?>
                    <tr class="bg-white border-b">
                        <td class="px-6 py-4"><?php echo $usuario->getNombre() ?></td>
                        <td class="px-6 py-4"><?php echo $usuario->getApellido() ?></td>
                        <td class="px-6 py-4"><?php echo $usuario->getEmail() ?></td>
                        <td class="px-6 py-4"><?php echo $usuario->getDni() ?></td>
                        <td class="px-6 py-4"><?php echo $usuario->getFechaCreacion()->format('d/m/Y H:i') ?></td>
                        <td class="px-6 py-4"><?php echo $usuario->getFechaActualizacion()->format('d/m/Y H:i') ?></td>
                        <th class="px-6 py-4"><a class="text-red-700 hover:text-red-400" href="#" data-id="<?php echo $usuario->getId() ?>">Eliminar</a></th>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php } ?>
        </div>
    </main>
    <?php require_once APP . '/views/layouts/footer.php' ?>
    <?php require_once APP . '/views/layouts/scripts.php' ?>

    <script>
        // Variables
        let idFormulario = "#perfiles_form";
        let rutaStore = "<?php echo BASE_URL . '/perfiles/store' ?>";
        let rutaUpdate = "<?php echo BASE_URL . '/perfiles/update/:id' ?>"; // marcador :id para reemplazarlo despues con js


        // Configuramos el formulario con el crear y actualizar
        configFormulario(idFormulario, rutaStore, rutaUpdate, function() {
            $('#btnRegresar').click();
        });

        $('#btnRegresar').on('click', function(event) {
            event.preventDefault();
            window.location.href = "<?php echo BASE_URL . '/perfiles' ?>";
        });

        $('table tbody tr').on('click', 'a[data-id]', function(event) {
            event.preventDefault();
            let ruta = "<?php echo BASE_URL . '/usuarios/destroy/' ?>" + $(this).attr('data-id');
            console.log(ruta);
            
            Swal.fire({
            title: '¿Estás seguro?',
            text: '¡No podrás revertir esto!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminarlo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:  ruta,
                    method: 'DELETE',
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('¡Eliminado!', response.message, 'success');
                            window.location.href = "<?php echo BASE_URL . '/perfiles/show/' ?>" + $(this).attr('data-id');
                        } 
                        else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    }
                });
            }
        });
        });
    </script>
</body>