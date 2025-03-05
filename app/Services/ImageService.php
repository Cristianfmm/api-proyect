<?php

namespace App\Services;

use GuzzleHttp\Client;

class ImageService
{
    public function getRandomImageUrl()
    {
        $client = new Client();
        $response = $client->get('https://picsum.photos/200'); // Servicio que devuelve imágenes aleatorias

        // Retorna la URL de la imagen obtenida
        return $response->getHeader('Location')[0];
    }
}

?>