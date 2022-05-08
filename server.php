<?php
require 'vendor/autoload.php';
$server = new soap_server();

$namespace = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$server->configureWSDL('HospitalApp');
$server->wsdl->schemaTargetNamespace = $namespace;

$server->wsdl->addComplexType(
    'medicalpatient',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'ID' => array('name' => 'ID', 'type' => 'xsd:string'),
        'first_name' => array('name' => 'first_name', 'type' => 'xsd:string'),
        'last_name' => array('name' => 'last_name', 'type' => 'xsd:string'),
        'birthdate' => array('name' => 'birthdate', 'type' => 'xsd:date'),
        'age' => array('name' => 'age', 'type' => 'xsd:number_format'),
    ));

function get_message($name) {
    return "Welcome $name";
}

$server->register('get_message',
    array('name' => 'xsd:string'),
    array('return' => 'xsd:string'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Metode Hello World Sederhana'
);

function get_diagnose($category, $name) {
    if($category == 'basic') {
        $medicalrecord = join(', ', array(
            "Fever", "Influenza", "Allergic of Antibiotic"
        ));
        return "The patient: $name diagnoses are: $medicalrecord";
    }
    else {
        return 'The patient doesn\'t have basic medical record';
    }
}

$server->register('get_diagnose',
    array(
        'category' => 'xsd:string',
        'name' => 'xsd:string'
    ),
    array('return' => 'xsd:string'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Metode Get Diagnose Sederhana'
);

function reformat_data($medicalpatient) {
    $medicalpatient['ID'] = 'KODE: ' . $medicalpatient['ID'];
    $medicalpatient['first_name'] = 'Mr. ' . $medicalpatient['first_name'];
    $medicalpatient['age'] = date('Y-m-d') - $medicalpatient['birthdate'];

    return $medicalpatient;
}

$server->register('reformat_data',
    array('medicalpatient' => 'tns:medicalpatient'),
    array('return' => 'tns:medicalpatient'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Metode mengubah data pasien'
);

$server->service(file_get_contents("php://input"));
exit();
