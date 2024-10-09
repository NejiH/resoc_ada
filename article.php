<?php


// Boucle while pour création d'article
global $lesInformations;
while ($post = $lesInformations->fetch_assoc()) {
    ?>
    <article>
        <h3>
            <time><?php echo $post['created'] ?></time>
        </h3>
        <address><a
                href="http://localhost:8888/resoc_n1/wall.php?user_id=<?php echo $post['user_id'] ?>"><?php echo $post['author_name'] ?></a>
        </address>
        <div>
            <p><?php echo $post['content'] ?></p>
        </div>
        <footer>
            <small>♥ <?php echo $post['like_number'] ?></small>
            <a href="">#<?php echo str_replace(',', ', #', $post['taglist']) ?></a>
        </footer>
    </article>
    <?php
}