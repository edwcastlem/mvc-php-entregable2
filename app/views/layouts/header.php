<header>
    <?php
        $items = [
            [
                'texto' => 'Inicio',
                'url' => BASE_URL . '/'
            ],
            [
                'texto' => 'Perfiles',
                'url' => BASE_URL . '/perfiles'
            ],
            [
                'texto' => 'Usuarios',
                'url' => BASE_URL . '/usuarios'
            ],
            [
                'texto' => 'Categorias',
                'url' => BASE_URL . '/categorias'
            ],
            [
                'texto' => 'Productos',
                'url' => BASE_URL . '/productos'
            ],
            [
                'texto' => 'Proveedores',
                'url' => BASE_URL . '/proveedores'
            ]
        ];

        CargadorHelpers::loadHelper('nav_component', compact('items'));
    ?>
</header>