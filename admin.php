<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Administration</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php
    include 'connect.php';
    include 'header.php';
    ?>
    <div id="wrapper" class="admin">
        <aside>
            <h2>Mots-clés</h2>
            <?php
            $laQuestionEnSql = "SELECT * FROM `tags` LIMIT 50";
            $lesInformations = $mysqli->query($laQuestionEnSql);

            if (!$lesInformations) {
                echo ("Échec de la requête : " . $mysqli->error);
                exit();
            }

            while ($tag = $lesInformations->fetch_assoc()) {
                ?>
                <article>
                    <h3><?php echo $tag['label']; ?></h3>
                    <nav>
                        <a href="tags.php?tag_id=<?php echo $tag['id']; ?>">Messages</a>
                    </nav>
                </article>
            <?php } ?>
        </aside>
        <main>
            <h2>Utilisatrices</h2>
            <?php
            $laQuestionEnSql = "
                SELECT users.id, users.alias
                FROM users
                LIMIT 50
            ";
            $lesUtilisatrices = $mysqli->query($laQuestionEnSql);

            if (!$lesUtilisatrices) {
                echo ("Échec de la requête : " . $mysqli->error);
                exit();
            }

            while ($user = $lesUtilisatrices->fetch_assoc()) {
                ?>
                <article>
                    <h3><?php echo $user['alias']; ?></h3>
                    <nav>
                        <a href="wall.php?user_id=<?php echo $user['id']; ?>">Mur</a>
                        | <a href="feed.php?user_id=<?php echo $user['id']; ?>">Flux</a>
                        | <a href="settings.php?user_id=<?php echo $user['id']; ?>">Paramètres</a>
                        | <a href="followers.php?user_id=<?php echo $user['id']; ?>">Suiveurs</a>
                        | <a href="subscriptions.php?user_id=<?php echo $user['id']; ?>">Abonnements</a>
                    </nav>
                </article>
            <?php } ?>
        </main>
    </div>
</body>

</html>