<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Les messages par mot-clé</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
    <?php

    include 'includes/header.php';
    include 'database/connect.php';

    $tagId = intval($_GET['tag_id']);


    $sqlTag = "SELECT * FROM tags WHERE id='$tagId'";
    $resultTag = $mysqli->query($sqlTag);
    $tag = $resultTag->fetch_assoc();
    ?>

    <div id="wrapper">
        <aside>
            <img src="assets/user.jpg" alt="Image d'illustration" />
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez les derniers messages comportant
                    le mot-clé <?php echo $tag['label']; ?> (n° <?php echo $tagId; ?>)
                </p>
            </section>
        </aside>

        <main>
            <?php

            $laQuestionEnSql = "
                SELECT posts.content, posts.created, users.alias as author_name,  
                COUNT(likes.id) as like_number,  
                GROUP_CONCAT(DISTINCT tags.label) AS taglist
                FROM posts_tags as filter 
                JOIN posts ON posts.id = filter.post_id
                JOIN users ON users.id = posts.user_id
                LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                LEFT JOIN tags ON posts_tags.tag_id = tags.id 
                LEFT JOIN likes ON likes.post_id = posts.id 
                WHERE filter.tag_id = '$tagId' 
                GROUP BY posts.id
                ORDER BY posts.created DESC
            ";
            $lesInformations = $mysqli->query($laQuestionEnSql);

            // Display posts
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