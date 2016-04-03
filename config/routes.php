<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/askarelista', function() {
    HelloWorldController::askarelista();
});
$routes->get('/askarenakyma', function() {
    HelloWorldController::askarenakyma();
});

$routes->get('/askaremuokkaus', function() {
    HelloWorldController::askaremuokkaus();
});
$routes->get('/kirjautumissivu', function() {
    HelloWorldController::kirjautumissivu();
});

