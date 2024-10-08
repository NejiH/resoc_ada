<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Mes abonnés </title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        <header>
            <img src="resoc.jpg" alt="Logo de notre réseau social"/> 
            <nav id="menu">
                <a href="news.php">Actualités</a>
                <a href="wall.php?user_id=5">Mur</a>
                <a href="feed.php?user_id=5">Flux</a>
                <a href="tags.php?tag_id=1">Mots-clés</a>
            </nav>
            <nav id="user">
                <a href="#">Profil</a>
                <ul>
                    <li><a href="settings.php?user_id=5">Paramètres</a></li>
                    <li><a href="followers.php?user_id=5">Mes suiveurs</a></li>
                    <li><a href="subscriptions.php?user_id=5">Mes abonnements</a></li>
                </ul>

            </nav>
        </header>
        <div id="wrapper">          
            <aside>
                <img src = "user.jpg" alt = "Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez la liste des personnes qui
                        suivent les messages de l'utilisatrice
                        n° <?php echo intval($_GET['user_id']) ?></p>

                </section>
            </aside>
            <main class='contacts'>
    <?php
    // Étape 1 : Récupérer l'id de l'utilisateur
    $userId = intval($_GET['user_id']);
    
    // Étape 2 : Se connecter à la base de données
    $mysqli = new mysqli("localhost", "root", "", "socialnetwork");
    
    // Vérifier la connexion
    if ($mysqli->connect_errno) {
        echo "Échec de la connexion : " . $mysqli->connect_error;
        exit();
    }
    
    // Étape 3 : Récupérer les informations des abonnés
    $laQuestionEnSql = "
        SELECT users.*
        FROM followers
        LEFT JOIN users ON users.id=followers.following_user_id
        WHERE followers.followed_user_id='$userId'
        GROUP BY users.id
    ";
    $lesInformations = $mysqli->query($laQuestionEnSql);
    
    if (!$lesInformations) {
        echo "Échec de la requête : " . $mysqli->error;
        exit();
    }

    while ($follower = $lesInformations->fetch_assoc()) {
        ?>
        <article>
            <img src="user.jpg" alt="blason"/>
            <h3><?php echo htmlspecialchars($follower['alias']); ?></h3> 
            <p>id:<?php echo $follower['id']; ?></p> 
        </article>
        <?php
    }
    ?>
            </main>
        </div>
    </body>
</html>

