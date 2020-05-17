<?php

    /* 
    ESTE SERVER TIENE 2 POSIBILIDADES: 

    1)  Pedidos tipo POST: verifica que las credenciales recibidas sean válidas, 
        en tal caso, responde con un token generado de una forma segura (en nuestro caso, usando sha1)
        Este token deberá ser almacenado en una BD y deberá tener una caducidad en el tiempo

    2)  Pedidos tipo GET: Estos pedidos serán verificaciones de ese token con los tokens válidos, 
        que deberán estar en una BD, y devolverá true o false dependiendo de si el token es correcto o no */

    $method = strtoupper( $_SERVER['REQUEST_METHOD'] );

    $token = sha1('Esto es un secreto!!');
    
    if ( $method === 'POST' ) {
        if ( !array_key_exists( 'HTTP_X_CLIENT_ID', $_SERVER ) || !array_key_exists( 'HTTP_X_SECRET', $_SERVER ) ) {
            http_response_code( 400 );
    
            die( 'Faltan parametros' );
        }
    
        $clientId = $_SERVER['HTTP_X_CLIENT_ID'];
        $secret = $_SERVER['HTTP_X_SECRET'];
    
        if ( $clientId !== '1' || $secret !== 'SuperSecreto!' ) {
            http_response_code( 403 );
    
            die ( "No autorizado");
        }
    
        echo "$token";
    } 
    elseif ( $method === 'GET' ) {
        if ( !array_key_exists( 'HTTP_X_TOKEN', $_SERVER ) ) {
            http_response_code( 400 );
    
            die ( 'Faltan parametros' );
        }
    
        if ( $_SERVER['HTTP_X_TOKEN'] == $token ) {
            echo 'true';
        } else {
            echo 'false';
        }
    } 
    else {
        echo 'false';
    }
    
?>