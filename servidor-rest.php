<?php

    /* Definimos los tipos de recursos que están permitidos */
    $allowedResourceTypes = [
        'books',
        'authors',
        'genres',
    ];

    /* Validamos que los recursos que nos solicitan están dentro de los recursos disponible
    Para ello, guardamos lo que viene de la URL, en el campo 'resource_type' */
    $resourceType = $_GET['resource_type'];

    /* verificamos que si lo que viene de la URL NO pertenece al array,
    entonces generará un error y el webservice terminará */
    if (!in_array($resourceType, $allowedResourceTypes)) {
        die;
    }

    /* Definimos los recursos */
    $books = [
        1 => [
            'title'=>'Lo que el viento se llevó',
            'id_author' => 2,
            'id_gender'=> 2,
        ],
        2 => [
            'title'=>'La Iliada',
            'id_author' => 1,
            'id_gender'=> 1,
        ],
        3 => [
            'title'=>'La odisea',
            'id_author' => 1,
            'id_gender'=> 1,
        ],
    ];

    /* Avisamos al cliente el que le vamos a enviar un json */
    header('Content-Type: application/json');

    /* Saber qué libro exactamente nos solicitan, para ello, tomamos la variable 
    que viene de la URL: resourceId, pero antes hay q comprobar que 'resourceId' existe*/
    $resourceId = array_key_exists('resourceId', $_GET) ? $_GET['resourceId'] : '';


    /* Generamos la respuestaa asumiendo que el pedido es correcto
    $_SERVER['REQUEST_METHOD']: Variable para conocer el método con el que realizó la petición */
    switch (strtoupper($_SERVER['REQUEST_METHOD'])) {
        case 'GET':
            /* si 'resourceId' está vacía: devolvemos colección entera */
            if (empty($resourceId)) {
                echo json_encode($books);
            } else {
                /* si el contenido de 'resourceId' existe dentro de la variable $books: 
                devolvemos el recurso solicitado codificado en json*/
                if (array_key_exists($resourceId, $books)) {
                    echo json_encode($books[$resourceId]);
                }
            }
            
            break;
        case 'POST':
            # code...
            break;
        case 'PUT':
            # code...
            break;
        case 'DELETE':
            # code...
            break;
        default:
            # code...
            break;
    }
?>