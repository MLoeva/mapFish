<?php
declare(strict_types=1);

require_once 'flight/Flight.php';

// Configuration directe de PostgreSQL
$link = pg_connect("host=localhost port=5432 dbname=bdd_mapFish user=postgres password=postgres");
if (!$link) {
    die("Erreur de connexion à la base de données");
}
Flight::set('link', $link);

// Fonction helper pour faciliter l'accès à la connexion
Flight::map('db', function() {
    return Flight::get('link');
});

// Début de session
Flight::before('start', function() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
});

// Routes
Flight::route('/', function(){
    Flight::render('login.php');
});

// Exemple adapté pour PostgreSQL
Flight::route('POST /login', function(){
    $email = Flight::request()->data->email;
    $password = Flight::request()->data->password;
    
    $result = pg_query_params(Flight::db(), "SELECT * FROM utilisateurs WHERE email = $1", array($email));
    $user = pg_fetch_assoc($result);
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_pseudo'] = $user['pseudo'];
        Flight::redirect('/page_accueil');
    } else {
        Flight::render('login.php', ['error' => 'Email ou mot de passe incorrect']);
    }
});

// Exemple d'inscription adapté pour PostgreSQL
Flight::route('POST /signin', function(){
    $email = Flight::request()->data->email;
    $pseudo = Flight::request()->data->pseudo;
    $password = Flight::request()->data->password;
    $confirm_password = Flight::request()->data->confirm_password;
    
    if ($password !== $confirm_password) {
        Flight::render('signin.php', ['error' => 'Les mots de passe ne correspondent pas']);
        return;
    }
    
    // Vérification si l'email existe déjà
    $result = pg_query_params(Flight::db(), "SELECT id FROM utilisateurs WHERE email = $1", array($email));
    if (pg_fetch_assoc($result)) {
        Flight::render('signin.php', ['error' => 'Cet email est déjà utilisé']);
        return;
    }
    
    // Création du compte
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $result = pg_query_params(
        Flight::db(), 
        "INSERT INTO utilisateurs (email, password, pseudo) VALUES ($1, $2, $3) RETURNING id", 
        array($email, $hashed_password, $pseudo)
    );
    
    if ($result) {
        Flight::render('login.php', ['success' => 'Compte créé avec succès. Connectez-vous maintenant.']);
    } else {
        Flight::render('signin.php', ['error' => 'Erreur lors de la création du compte']);
    }
});

Flight::route('/signin', function() {
    Flight::render('signin.php');
});

Flight::route('/page_accueil', function() {
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