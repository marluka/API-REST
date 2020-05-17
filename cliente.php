<?php

    /* Ciente de SERVICIO WEB */

    /*  
    Asumimos que la URL a la que queremos acceder, nos va a ser 
    provista desde un parámetro de la línea de comandos 

    $ch - guardará el recurso cURL devuelto por curl_init() 
    */
    $ch = curl_init($argv[1]);

    /* 
    curl_setopt — Configura una opción para una transferencia cURL
    CURLOPT_RETURNTRANSFER - para devolver el resultado de la transferencia como 
    string del valor de curl_exec() en lugar de mostrarlo directamente
    */
    curl_setopt( 
        $ch, 
        CURLOPT_RETURNTRANSFER, 
        true 
    );

    /* Obtenemos la respuesta del servidor */
    $response = curl_exec($ch);

    /* Obtenemos el código de error recibido */
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    /* Tratamos el error recibido */
    switch ($httpCode) {
        case 200:
            echo 'Todo bien!';
            break;
        case 400:
            echo 'Pedido incorrecto';
            break;
        case 404:
            echo 'Recurso no encontrado';
            break;
        case 500:
            echo 'El servidor falló';
            break;
    }


?>