<?php
declare(strict_types=1);

require_once 'flight/Flight.php';

//debut modifs
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

// Routes
Flight::route('/', function(){
    Flight::render('login.php');
});

// Exemple adapté pour PostgreSQL
Flight::route('POST /login', function(){
    $email = Flight::request()->data->email;
    $password = Flight::request()->data->password;
    
    $result = pg_query_params(Flight::db(), "SELECT * FROM users WHERE email = $1", array($email));
    $user = pg_fetch_assoc($result);
    
    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        Flight::redirect('/dashboard');
    } else {
        Flight::render('login.php', ['error' => 'Email ou mot de passe incorrect']);
    }
});

// Exemple d'inscription adapté pour PostgreSQL
Flight::route('POST /register', function(){
    $email = Flight::request()->data->email;
    $password = Flight::request()->data->password;
    $confirm_password = Flight::request()->data->confirm_password;
    
    if ($password !== $confirm_password) {
        Flight::render('register.php', ['error' => 'Les mots de passe ne correspondent pas']);
        return;
    }
    
    // Vérification si l'email existe déjà
    $result = pg_query_params(Flight::db(), "SELECT id FROM users WHERE email = $1", array($email));
    if (pg_fetch_assoc($result)) {
        Flight::render('register.php', ['error' => 'Cet email est déjà utilisé']);
        return;
    }
    
    // Création du compte
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $result = pg_query_params(
        Flight::db(), 
        "INSERT INTO users (email, password) VALUES ($1, $2) RETURNING id", 
        array($email, $hashed_password)
    );
    
    if ($result) {
        Flight::render('login.php', ['success' => 'Compte créé avec succès. Connectez-vous maintenant.']);
    } else {
        Flight::render('register.php', ['error' => 'Erreur lors de la création du compte']);
    }
});

// ... (le reste de vos routes)

//fin modfs
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

// Démarrer Flight
Flight::start();

?>