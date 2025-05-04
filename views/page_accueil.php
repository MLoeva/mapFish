<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mapFish</title>
    <link rel="stylesheet" href="assets/page_accueil.css">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    
</head>

<body>
    <body>
    <div id=entete>
        <a href="/"><img src="images/logo.png" alt=""></a>
        <ul class=navigation>
            <li><a href="/portfolio">Portfolio</a></li>
            <li><a href="/about">A propos</a></li>
            <li><a href="/contact">Contact</a></li>
        </ul>
    </div>

    <div class="container">
        <?php
            if (!isset($_SESSION['user_pseudo'])) {
                header("Location: /login");
                exit();
            }
            $pseudo = $_SESSION['user_pseudo'];
        ?>

        <h1>Bienvenue, <?= htmlspecialchars($pseudo) ?></h1>
        <p>Vous êtes connecté avec succès.</p>
        <img src="https://as2.ftcdn.net/v2/jpg/02/37/04/41/1000_F_237044126_c0K5Jk7261DIz1suBl70TqmGPPbMrTaK.jpg" alt="">
        <a href="/" class="btn">Déconnexion</a>
    </div>
</body>

</html>