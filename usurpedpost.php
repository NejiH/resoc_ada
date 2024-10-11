<?php
session_start();
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Post d'usurpateur</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div id="wrapper">

        <aside>
            <h2>Présentation</h2>
            <p>Sur cette page on peut poster un message en se faisant
                passer pour quelqu'un d'autre</p>
        </aside>
        <main>
            <article>
                <h2>Poster un message</h2>
                <?php


                include 'database/connect.php';

                // récup liste des auteurs
                $listAuteurs = [];
                $laQuestionEnSql = "SELECT * FROM users";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                while ($user = $lesInformations->fetch_assoc()) {
                    $listAuteurs[$user['id']] = $user['alias'];
                }

                // TRAITEMENT DU FORMULAIRE
                if (isset($_POST['auteur'])) {
                    //  données du formulaire
                    $authorId = $_POST['auteur'];
                    $postContent = $_POST['message'];

                    // securiser les données
                    $authorId = intval($mysqli->real_escape_string($authorId));
                    $postContent = $mysqli->real_escape_string($postContent);

                    // verif que message est pas vide
                    if (!empty($postContent)) {

                        $lInstructionSql = "INSERT INTO posts (id, user_id, content, created) 
                                            VALUES (NULL, $authorId, '$postContent', NOW())";

                        // execution requête
                        if ($mysqli->query($lInstructionSql)) {
                            echo "Message posté avec succès en tant que : " . $listAuteurs[$authorId];
                        } else {
                            echo "Impossible d'ajouter le message : " . $mysqli->error;
                        }
                    } else {
                        echo "Le contenu du message ne peut pas être vide.";
                    }
                }
                ?>

                <!-- formulaire pour poster message -->
                <form action="usurpedpost.php" method="post">
                    <dl>
                        <dt><label for='auteur'>Auteur</label></dt>
                        <dd>
                            <select name='auteur' id="auteur" required>
                                <?php
                                foreach ($listAuteurs as $id => $alias) {
                                    echo "<option value='$id'>$alias</option>";
                                }
                                ?>
                            </select>
                        </dd>

                        <dt><label for='message'>Message</label></dt>
                        <dd><textarea name='message' id="message" required></textarea></dd>
                    </dl>
                    <input type='submit' value="Poster le message">
                </form>
            </article>
        </main>
    </div>
</body>

</html>