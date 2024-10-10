<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Mes abonnés</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php include 'header.php'; ?>

    <div id="wrapper">
        <aside>
            <img src="assets/user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez la liste des personnes qui suivent les messages de l'utilisatrice
                    n° <?php echo $_GET['user_id']; ?>
                </p>
            </section>
        </aside>
        <main class='contacts'>
            <?php
            include 'connect.php';

            // step 1: get user ID
            $userId = $_GET['user_id'];

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
                        <img src="assets/user.jpg" alt="Portrait de l'utilisateur" />
                        <h3><?php echo $follower['alias']; ?></h3><a
                            href="http://localhost:8888/resoc_n1/wall.php?user_id=<?php echo $follower['id'] ?>"><?php echo $follower['alias']; ?></a>
                        </h3>
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