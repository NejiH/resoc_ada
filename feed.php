<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Flux</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php

    include 'header.php';
    include 'connect.php';


    $userId = intval($_GET['user_id']);

    $sqlUser = "SELECT * FROM `users` WHERE id='$userId'";
    $resultUser = $mysqli->query($sqlUser);
    $user = $resultUser->fetch_assoc();
    ?>

    <div id="wrapper">
        <aside>
            <img src="assets/user.jpg" alt="Portrait de l'utilisateur" />
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez tous les messages des utilisateurs
                    auxquels est abonné(e) <?php echo $user['alias']; ?> (n° <?php echo $userId; ?>).
                </p>
            </section>
        </aside>

        <main>
            <?php
            // fetch posts
            $sqlPosts = "
                SELECT posts.content, posts.created, users.alias as author_name,  
                COUNT(likes.id) as like_number,  
                GROUP_CONCAT(DISTINCT tags.label) AS taglist
                FROM followers 
                JOIN users ON users.id = followers.followed_user_id
                JOIN posts ON posts.user_id = users.id
                LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                LEFT JOIN tags ON posts_tags.tag_id = tags.id 
                LEFT JOIN likes ON likes.post_id = posts.id 
                WHERE followers.following_user_id='$userId' 
                GROUP BY posts.id
                ORDER BY posts.created DESC
            ";
            $resultPosts = $mysqli->query($sqlPosts);

            // display posts
            while ($post = $resultPosts->fetch_assoc()) {
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
                        <small>♥ <?php echo $post['like_number']; ?></small>
                        <a href="#">#<?php echo str_replace(',', ', #', $post['taglist']); ?></a>
                    </footer>
                </article>
            <?php } ?>
        </main>
    </div>
</body>

</html>