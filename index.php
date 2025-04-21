<?php
declare(strict_types=1);

session_start();

require_once 'flight/Flight.php';
// require 'flight/autoload.php';


Flight::route('/', function() {
    Flight::render('page_accueil.php');
});

Flight::route('/portfolio', function() {
    Flight::render('portfolio.php');
});

Flight::route('/about', function() {
    Flight::render('about.php');
});

Flight::route('/contact', function() {
    Flight::render('contact.php');
});

Flight::start();

?>