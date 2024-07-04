<?php 
    /**
     * Parametros:
     * activo: booleano para establecer el menu activo
     * url: link del enlace
     * texto: Texto del enlace
     */


    CargadorHelpers::loadHelper('utiles');
?>
    
<nav class="border-gray-200 px-4 lg:px-6 py-2.5 bg-gray-800">
    <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
        <div class="flex items-center lg:order-2">
            <a href="#" class="text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 hover:bg-gray-700 focus:outline-none focus:ring-gray-800">Iniciar sesión</a>
        </div>
        <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
            <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                <?php foreach($items as $item) { 
                    if (obtenerMenuActual() === strtolower($item['url'])) {
                ?>
                <li>
                    <a href="<?php echo $item['url'] ?>" class="block py-2 pr-4 pl-3 text-white rounded bg-primary-700 lg:bg-transparent lg:text-primary-700 lg:p-0" aria-current="page"><?php echo $item['texto'] ?></a>
                </li>
                <?php } else { ?>
                <li>
                    <a href="<?php echo $item['url'] ?>" class="block py-2 pr-4 pl-3 border-b border-gray-100 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0 text-gray-400 lg:hover:text-white hover:bg-gray-700 hover:text-white lg:hover:bg-transparent border-gray-700"><?php echo $item['texto'] ?></a>
                </li>
                <?php
                    }
                } ?>
            </ul>
        </div>
    </div>
</nav>