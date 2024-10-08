<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Mes abonnés</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <header>
        <img src="resoc.jpg" alt="Logo de notre réseau social" />
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
            <img src="user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez la liste des personnes qui suivent les messages de l'utilisatrice
                    n° <?php echo $_GET['user_id']; ?>
                </p>
            </section>
        </aside>

        <main class='contacts'>
            <?php
            // step 1: get user ID
            $userId = $_GET['user_id'];

            // step 2: connect to database
            $mysqli = new mysqli("localhost", "root", "", "socialnetwork");

            // check connection 
            if ($mysqli->connect_error) {
                die("Erreur de connexion: " . $mysqli->connect_error);
            }

            // step 3: write query 
            $query = "
                SELECT users.*
                FROM followers
                LEFT JOIN users ON users.id = followers.following_user_id
                WHERE followers.followed_user_id = $userId
            ";

            // step 4: execute query
            $result = $mysqli->query($query);

            // step 5: display followers
            if ($result->num_rows > 0) {
                while ($follower = $result->fetch_assoc()) {
                    ?>
                    <article>
                        <img src="user.jpg" alt="Portrait de l'utilisateur" />
                        <h3><?php echo $follower['alias']; ?></h3>
                        <p>ID: <?php echo $follower['id']; ?></p>
                    </article>
                    <?php
                }
            } else {
                echo "<p>Aucun abonné trouvé.</p>";
            }

            // step 6: close database 
            $mysqli->close();
            ?>
        </main>
    </div>
</body>

</html>