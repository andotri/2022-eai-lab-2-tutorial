<?php
require_once ('lib/nusoap.php');
$client = new nusoap_client('http://localhost/2022-eai-lab-2-tutorial/server.php');

$response = $client->call('get_message', array('name' => 'Fasilkom'));
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
