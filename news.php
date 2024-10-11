<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Actualités</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="assets/css/style.css" />

    <link rel="stylesheet">

</head>

<body>
    <?php
    // inclusion de la connexion à la base de données
    include 'database/connect.php';

    // inclusion du header
    include 'includes/header.php';
    ?>

    <div id="wrapper">
        <aside>
            <!-- présentation à gauche -->
            <img src="assets/user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <h3>Présentation</h3>
                <p>sur cette page, vous trouverez les derniers messages de toutes les utilisatrices du site.</p>
            </section>
        </aside>

        <main>
            <?php
            // requête pour récupérer les posts avec le nombre de likes
            $laQuestionEnSql = "
                SELECT posts.id as post_id,
                    posts.content,
                    posts.created,
                    posts.user_id,
                    users.alias as author_name,  
                    count(likes.id) as like_number,  
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                FROM posts
                JOIN users ON users.id = posts.user_id
                LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                LEFT JOIN tags ON posts_tags.tag_id = tags.id 
                LEFT JOIN likes ON likes.post_id = posts.id 
                GROUP BY posts.id
                ORDER BY posts.created DESC  
                LIMIT 5
            ";
            $lesInformations = $mysqli->query($laQuestionEnSql);

            // affichage des posts
            while ($post = $lesInformations->fetch_assoc()) {
                ?>
                <article>
                    <h3>
                        <time datetime='<?php echo $post['created']; ?>'><?php echo $post['created']; ?></time>
                    </h3>
                    <address>par <?php echo $post['author_name']; ?></address>
                    <div>
                        <p><?php echo $post['content']; ?></p>
                    </div>
                    <footer>
                        <!-- formulaire pour ajouter un like via un bouton en forme de coeur -->
                        <form action="like.php" method="post" style="display:inline;">
                            <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                            <button type="submit" class="like-button">
                                ♥ <?php echo $post['like_number']; ?>
                            </button>
                        </form>


                        <!-- afficher les tags associés au post -->
                        <a href="#"><?php echo str_replace(',', ', #', $post['taglist']); ?></a>
                    </footer>
                </article>
            <?php } ?>
        </main>
    </div>
</body>

</html>