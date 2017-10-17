<?php

namespace App;

require 'vendor/autoload.php';

use Dotenv\Dotenv;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

$dotenv = new Dotenv(__DIR__);
$dotenv->load();

try {
    $client = new Client([
        'headers' => [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . getenv('API_TOKEN'),
        ]
    ]);
    $response = $client->post(getenv('API_URL') . $argv[1]);
} catch (RequestException | ConnectException | ClientException $e) {
    $notification = 'Failed with: ';
    if ($e->hasResponse()) {
        $notification .=  $e->getResponse()->getStatusCode();
        $notification .=  ' ' . $e->getResponse()->getReasonPhrase();
    }

    echo $notification;
    return;
}

echo 'Succeeded with: ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase();