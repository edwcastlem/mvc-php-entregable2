<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ( isset($titulo) ) ? $titulo : 'SISTEMA DE GESTIÓN' ?></title>
    <?php require_once APP . '/views/layouts/head.php' ?>
</head>
<body>
    <?php require_once APP . '/views/layouts/header.php' ?>
    <main class="flex-grow flex items-center justify-center p-4 w-full max-w-screen-xl mx-auto">
        <div class="bg-white p-6 rounded shadow-md w-full">
            <h2 class="text-xl mb-4">Página principal</h2>
            <p class="my-4">Esta es la página principal.</p>
        </div>
    </main>
    <?php require_once APP . '/views/layouts/footer.php' ?>
    <?php require_once APP . '/views/layouts/scripts.php' ?>
</body>
</html>