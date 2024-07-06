<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>HOLA JIM!!!</h1>
    <p>
        <?php
        echo "Te llamas: " . LoginUtils::usuario()->getNombre();
        echo " Email: " . LoginUtils::usuario()->getEmail();
        ?>
    </p>
</body>

</html>