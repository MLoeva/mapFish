<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connexion a mapFish</title>
    <link rel="stylesheet" href="assets/page_accueil.css">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    
</head>

<body>
    <div id=entete>
        <a href="/"><img src="images/logo.png" alt=""></a>
    </div>


    <div class="container">
        <h1>Connexion</h1>
        
        <?php if (isset($error)): ?>
            <div class="alert error"><?= $error ?></div>
        <?php endif; ?>
        
        <?php if (isset($success)): ?>
            <div class="alert success"><?= $success ?></div>
        <?php endif; ?>
        
        <form action="/login" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn">Se connecter</button>
        </form>
        
        <p>Pas encore de compte? <a href="/signin">S'inscrire</a></p>
    </div>

    <div id=pied_page>
        <h1>pied de page</h1>
    </div>
</body>
</html>