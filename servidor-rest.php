<?php

    /* AUTENTICACIÓN VIA HMAC */

    /* Verificamos que el servidor recibe un token del cliente */
    if (!array_key_exists('HTTP_X_TOKEN', $_SERVER)) {
        die;
    }

    /* Validamos el token recibido en el SERVIDOR DE AUTENTICACIÓN para ello, 
    guadamos la URL donde va a estar escuchando el SERVIDOR DE AUTENTICACIÓN */
    $url = 'http://localhost:8001';

    /* Ejecutamos una llamada via curl al servidopr de autenticación 
    para q me valide el tocken*/
    $ch = curl_init($url);

    /* curl_setopt — Configura una opción para una transferencia cURL */
    curl_setopt( 
        $ch, 
        CURLOPT_HTTPHEADER, [
            "X-Token: {$_SERVER['HTTP_X_TOKEN']}",
        ]
    );

    curl_setopt( 
        $ch, 
        CURLOPT_RETURNTRANSFER, 
        true 
    );

    /* Realizamos la llamada */
    $ret = curl_exec($ch);

    /* Verificamos que el resultado de la llama es o no true */
    if ($ret !== 'true') {
        die;
    }
   

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
    que viene de la URL: resourceId, pero antes hay q comprobar que 'resourceId' existe */
    $resourceId = (array_key_exists('resource_id', $_GET)) ? $_GET['resource_id'] : '';


    /* Generamos la respuestaa asumiendo que el pedido es correcto
    $_SERVER['REQUEST_METHOD']: Variable para conocer el método con el que realizó la petición */
    switch (strtoupper($_SERVER['REQUEST_METHOD'])) {
        case 'GET':
            /* si 'resourceId' está vacía: devolvemos colección entera */
            if (empty($resourceId)) {
                echo json_encode($books);
            } else {
                /* si el contenido de 'resourceId' existe dentro de la variable $books: 
                devolvemos el recurso solicitado codificado en json */
                if (array_key_exists($resourceId, $books)) {
                    echo json_encode($books[$resourceId]);
                }
            }
            break;
        case 'POST':
            /* file_get_contents - Transmite un fichero completo a una cadena 
            php://input - es un flujo de sólo lectura que permite leer datos del cuerpo solicitado */
            $json = file_get_contents('php://input');

            /* Agregamos un nuevo libro a nuestra colección mediante la 
            decodificación de ese texto json que acabamos de recibir */
            $books[] = json_decode($json, true);

            /* Una buena práctica es devolver el id que se ha generado para el nuevo objeto, 
            para ello, de todas las claves, solicitamos la última */
            // echo array_keys($books)[count($books) - 1];
            echo json_encode($books);
            
            break;
        case 'PUT':
            /* verificamos que el recurso existe, de otro modo, 
            no sabremos cuál es el que tenemos que modificar */
            if (!empty($resourceId) && array_key_exists($resourceId, $books)) {
                /* Tomamos la entrada cruda */
                $json = file_get_contents('php://input');

                /* Transformamos el json recibido a un nuevo elemento del array*/
                $books[$resourceId] = json_decode($json, true);

                /* Retornamos la colección modificada en formato json */
                echo json_encode($books);  
            }
            break;
        case 'DELETE':
            /* verificamos que el recurso existe, de otro modo, 
            no podemos eliminar un recurso que no tenemos en la colección */
            if (!empty($resourceId) && array_key_exists($resourceId, $books)) {
                /* unset - Destruye una clave especificada de un array */
                unset($books[$resourceId]);
            }
            /* Mostramos la colección para verificar que se han hecho los cambios */
            echo json_encode($books);
            break;
            
    }

    /* En un caso real, para llevar a cabo las acciones que se solicitan de GET, POST, PUT y DELETE 
    usaríamos sentencias sql contra una base de datos, en nuestro caso, estamos trabajando con un array*/
?>