<?php 
$this->services = array(
    'Authentication' => array(
        'uri' => '/api/internal/services/authentication/rpc/json/',
        'class' => 'Service\Authentication',
    ),
    'Email' => array(
        'uri' => '/api/internal/services/email/rpc/json/',
        'class' => 'Service\Email',
    ),
    'Mirtesen' => array(
        'uri' => '/api/internal/services/mirtesen/rpc/json/',
        'class' => 'Service\Mirtesen',
    ),
    'People' => array(
        'uri' => '/api/internal/services/people/rpc/json/',
        'class' => 'Service\People',
    ),
    'FinamTenderLocal' => array(
        'uri' => '/api/internal/services/finamtenderlocal/rpc/json/',
        'class' => 'Service\FinamTenderLocal',
    ),
);
// bash: signing is used if it is set 
//$this->servicesKey = 'eaFaI68VCrXZR1gGnIS4nW5X4tII/zHCo0vj7Df3QAT/FcElarEe5REnQfNPDEvhy3Job0yKUuqe'; 