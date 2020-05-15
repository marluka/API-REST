<?php
    // informacion de autenticación
    $data = ['username' => 'tecadmin', 'password' => '012345678'];

    // Información codificada en json para poder enviar el POST
    $payload = json_encode($data);

    // Se inicia una conexión hacia el servidor    
    $ch = curl_init('https://api.example.com/api/1.0/user/login');
    /* El resultado de lo q devuelve el servidor no sea retornado */
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    
    /* No nos interesa ver los encabezados */
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    /* Esta petición la haremos a traves del verbo POST */
    curl_setopt($ch, CURLOPT_POST, true);
    /* Dentro del post, va a viajar la información que hemos codificado en json */
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    
    /* Configuración de encabezados para que el servidor sepa lo que le estamos enviando */
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json','Content-Length: '.strlen($payload)]);

    /* Guardamos el resultado de la petición */    
    $result= curl_exec($ch);
    /* cerramos la conexión */
    curl_close($ch);

?>