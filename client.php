<?php
require 'vendor/autoload.php';

$namespace = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$namespace = str_replace('client.php','server.php', $namespace);
$client = new nusoap_client($namespace);

$response = $client->call('get_message', array(
    'name' => 'Fasilkom'
));
echo $response;

echo '<br>';
$response = $client->call('get_diagnose', array(
    'category' => 'basic',
    'name' => 'Jack'
));
echo $response;

echo '<br>';
$data = array(
    'ID' => '1',
    'first_name' => 'Jack',
    'last_name' => 'Sparrow',
    'birthdate' => '1994-03-23',
);
$response = $client->call('reformat_data', array(
    'medicalpatient' => $data
));
echo '<pre>';
print_r($response);
echo '</pre>';
