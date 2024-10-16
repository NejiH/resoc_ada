<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Mur</title>
    <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>

    <?php
    include 'includes/header.php';
    include 'database/connect.php';
    $userId = intval($_GET['user_id']);
    $sqlUser = "SELECT * FROM users WHERE id='$userId'";
    $resultUser = $mysqli->query($sqlUser);
    $user = $resultUser->fetch_assoc();
    ?>

    <div id="wrapper">

        <aside>
            <img src="assets/user.jpg" alt="Portrait de l'utilisateur" />
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez tous les messages de l'utilisateur :
                    <?php echo $user['alias']; ?>
                    (n° <?php echo $userId; ?>)
                </p>
            </section>
        </aside>

        <main>

            <!-- formulaire Message -->
            <form id="formulaireMessageWall" method="POST" action="wall.php?user_id=<?php echo $userId ?>">
                <textarea name="postMessage" placeholder="Poster un message..." required></textarea>
                <!-- Ajouter un menu deroulant (inspiration usurpedpost) pour choisir le ou les tags a appliquer -->
                <button name="btnPostMessage" value="userMessage" type="submit">Poste ton message</button>
            </form>

            <?php
            if (isset($_POST['postMessage'])) {
                echo $_POST['postMessage'];
                $requette = "INSERT INTO `posts` (`user_id`, `content`, `created`, `parent_id`) VALUES (" . $userId . ",'" . $_POST['postMessage'] . "', NOW(), NULL)";
                // echo $requette;
                $resultUser = $mysqli->query($requette);
            }
            ?>

            <?php
            // Display posts
            $laQuestionEnSql = "
                SELECT posts.id as post_id, posts.content, posts.created, posts.user_id, users.alias as author_name, 
                COUNT(likes.id) as like_number, GROUP_CONCAT(DISTINCT tags.label) AS taglist
                FROM posts
                JOIN users ON users.id = posts.user_id
                LEFT JOIN posts_tags ON posts.id = posts_tags.post_id
                LEFT JOIN tags ON posts_tags.tag_id = tags.id
                LEFT JOIN likes ON likes.post_id = posts.id
                WHERE posts.user_id='$userId'
                GROUP BY posts.id
                ORDER BY posts.created DESC";

            $lesInformations = $mysqli->query($laQuestionEnSql);
            //$newPost = $lesInformations->fetch_assoc();
            while ($post = $lesInformations->fetch_assoc()) {
                ?>

                <article>
                    <h3>
                        <time datetime='<?php echo $post['created']; ?>'><?php echo $post['created']; ?></time>
                    </h3>
                    <address>par <a
                            href="wall.php?user_id=<?php echo $post['user_id']; ?>"><?php echo $user['alias']; ?></a>
                    </address>
                    <div>
                        <p><?php echo $post['content']; ?></p>
                    </div>
                    <footer>

                        <form action="like.php" method="post" style="display:inline;">
                            <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                            <button type="submit" class="like-button"> ♥ <?php echo $post['like_number']; ?></button>
                        </form>
                        <a href="#">#<?php echo str_replace(',', ', #', $post['taglist']); ?></a>
                    </footer>
                </article>

            <?php } ?>

        </main>
    </div>
</body>

</html>