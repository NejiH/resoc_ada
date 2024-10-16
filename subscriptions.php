<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Mes abonnements</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
    <?php
    include 'database/connect.php';
    include 'includes/header.php';
    include 'includes/user_id.php';
    ?>

    <div id="wrapper">
        <aside>
            <img src="assets/user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez la liste des personnes dont l'utilisatrice
                    n° <?php echo $_GET['user_id']; ?>
                    suit les messages.
                </p>
            </section>
        </aside>

        <main class='contacts'>
            <?php
            // step 1: get user ID
            // $userId = $_GET['user_id'];
            $userId = intval($_GET['user_id']);

            // check connection 
            if ($mysqli->connect_error) {
                die("Erreur de connexion: " . $mysqli->connect_error);
            }

            // step 3: write query for subscriptions 
            $query = "
                SELECT users.* 
                FROM followers 
                LEFT JOIN users ON users.id = followers.followed_user_id 
                WHERE followers.following_user_id = $userId
            ";

            // step 4: execute query
            $result = $mysqli->query($query);

            // step 5: display subscriptions
            if ($result->num_rows > 0) {
                while ($abonnement = $result->fetch_assoc()) {
                    ?>
                    <article>
                        <img src="user.jpg" alt="Portrait de l'utilisateur" />
                        <h3><a href="wall.php?user_id=<?php echo $abonnement['id'] ?>"><?php echo $abonnement['alias']; ?></a>
                        </h3>
                        <p>ID: <?php echo $abonnement['id'] ?></p>
                    </article>
                    <?php
                }
            } else {
                echo "<p>Aucun abonnement trouvé.</p>";
            }

            // step 6: close database 
            $mysqli->close();
            ?>
        </main>
    </div>
</body>

</html>