<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/askare/askarelista', function() {
    AskareController::askarelista();
});
$routes->get('/askare/askarenakyma/:askare_id', function($askare_id) {
    AskareController::askarenakyma($askare_id);
});

//$routes->get('/index', function() {
//    AskareController::askarelista();
//});

$routes->post('/askare', function() {
    AskareController::tallenna();
});

$routes->get('/askare/uusi', function() {
    AskareController::uusi();
});
$routes->get('/askare/askaremuokkaus/:askare_id', function($askare_id) {
    AskareController::muokkaa($askare_id);
});
$routes->post('/askare/askaremuokkaus/:askare_id', function($askare_id) {
    AskareController::paivita($askare_id);
});

$routes->post('/askare/poista/:askare_id', function($askare_id) {
    AskareController::poista($askare_id);
});

$routes->get('/kayttaja/login', function() {
    KayttajaController::kirjautuminen();
});

$routes->post('/kayttaja/login', function() {
    KayttajaController::kirjaudu();
});

$routes->post('/kayttaja/logout', function() {
    KayttajaController::logout();
});

$routes->get('/luokka/luokkalista', function() {
    LuokkaController::luokkalista();
});

$routes->post('/luokka/luokkalista', function() {
    LuokkaController::uusi();
});

$routes->post('/luokka/poista/:luokka_id', function($luokka_id) {
    LuokkaController::poista($luokka_id);
});

$routes->get('/luokka/lmuokkaus/:luokka_id', function($luokka_id) {
    LuokkaController::muokkaa($luokka_id);
});

$routes->post('/luokka/lmuokkaus/:luokka_id', function($luokka_id) {
    LuokkaController::paivita($luokka_id);
});

$routes->get('/kayttaja/uusi', function() {
    KayttajaController::uusi();
});

$routes->post('/kayttaja/uusi', function() {
    KayttajaController::uusi_kayttaja();
});




