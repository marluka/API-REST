<?php

  /*   Transformar una URL bonita (como nos pide REST) a una URL útil que 
    nos permita procesar los parámetros de la manera en que PHP los necesita 
    La idea es que sea este archivo y no el Server el que reciba directamente 
    las peticiones */

    $matches = $_GET = [];

    // Excepcion para las  url principal sea index.html
    if (in_array( $_SERVER["REQUEST_URI"], [ '/index.html', '/', '' ] )) {
        echo file_get_contents( 'index.html' );
        die;
    }

    /* Comprobamos que la URI que recibimos coincida con el patrón de 
    un string con esta estructura: /example.com/recurso*/
    if (preg_match('/\/([^\/]+)\/([^\/]+)/', $_SERVER["REQUEST_URI"], $matches)) {
        /* Si coincide el patrón, generamos las variables $_GET utilizando las conincidencias */
        $_GET['resource_type']= $matches[1];
        $_GET['resource_id']= $matches[2];

        error_log(print_r($matches, 1));

        /* Delegamos el control en servidor-rest.php para que continúe como si la llamada se 
        hubiese hecho pasando los parámetros directamente desde la URL*/
        require 'servidor-rest.php';
    }
    elseif (preg_match('/\/([^\/]+)\/?/', $_SERVER["REQUEST_URI"], $matches)) {
        /* Esta condición hace lo mismo que la primera pero para cuando 
        la petición es para una colección y no para un recurso en particular */
        $_GET['resource_type']= $matches[1];

        error_log(print_r($matches, 1));

        require 'servidor-rest.php';
    }
    else{
        /* Si la petición no conincide con las anteriores, el servidor responderá con un error */
        error_log('No matches');
        http_response_code(404);
    }
?>