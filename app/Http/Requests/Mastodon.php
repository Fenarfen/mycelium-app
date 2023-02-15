<?php

namespace GuzzleHttp;

use guzzlehttp\Client;

$client = new Client(['timeout'  => 2.0]);

$response = $client->request('GET', 'http://httpbin.org/');
echo $response;
