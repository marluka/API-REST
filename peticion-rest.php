<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php 
        // Guardamos el string en una variable
        $json =  file_get_contents('https://xkcd.com/info.0.json');

        // json_decode: Convierte un string codificado en JSON a una variable de PHP.
        // Esta función sólo trabaja con string codificados en UTF-8.
        // El parámetro true, es para que los object devueltos sean convertidos a array asociativos.
        $data = json_decode($json, true);

        // Mostramos la propiedad "img" de los datos optenidos
        echo '<img src="'.$data['img'].'" alt="">';

    ?>

</body>

</html>