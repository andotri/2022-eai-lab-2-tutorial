<?php
require_once ('lib/nusoap.php');
$server = new soap_server();

$namespace = 'http://localhost/2022-eai-lab-2-tutorial/server.php';
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

function get_diagnose($category, $name) {
    if($category == 'basic') {
        $medicalrecord = join(', ', array(
            "Fever", "Influenza", "Allergic of Antibiotic"
            ));
        return "The patient: $name diagnoses are: $medicalrecord";
    }
    else {
        return 'The patient doesn\'t have basic medical record ';
    }
}

function reformat_data($medicalpatient) {
    $medicalpatient['ID'] = 'KODE: ' . $medicalpatient['ID'];
    $medicalpatient['first_name'] = 'Mr. ' . $medicalpatient['first_name'];
    $medicalpatient['age'] = date('Y-m-d') - $medicalpatient['birthdate'];

    return $medicalpatient;
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

$server->register('reformat_data',
    array('medicalpatient' => 'tns:medicalpatient'),
    array('return' => 'tns:medicalpatient'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Metode mengubah data pasien'
);

if(!isset($HTTP_RAW_POST_DATA)) {
    $HTTP_RAW_POST_DATA = file_get_contents('php://input');
}
$server->service(file_get_contents("php://input"));
exit();
