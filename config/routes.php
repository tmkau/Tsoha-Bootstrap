<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/askare/askarelista', function() {
    AskareetController::askarelista();
});
$routes->get('/askare/askarenakyma/:id', function($askare_id) {
    AskareController::askarenakyma($askare_id);
});

$routes->get('/askare/askaremuokkaus', function() {
    HelloWorldController::askaremuokkaus();
});
$routes->get('/index', function() {
    AskareetController::askarelista();
});
$routes->get('/askare/kirjautumissivu', function() {
    HelloWorldController::kirjautumissivu();
});

$routes->post('/askare', function() {
    AskareController::tallenna();
});

$routes->get('/askare/uusi', function() {
    AskareController::uusi();
});


