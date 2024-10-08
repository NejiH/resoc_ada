<?php

// Connexion à la base de données avec erreur version ARTICLE
$mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
if ($mysqli->connect_errno) {
    echo "<article>";
    echo ("Échec de la connexion : " . $mysqli->connect_error);
    echo ("<p>Indice: Vérifiez les parametres de <code>new mysqli(...</code></p>");
    echo "</article>";
    exit();
}

//Variable que la requete se fasse dans notre base de données avec condition d'erreur
$lesInformations = $mysqli->query($laQuestionEnSql);
// Vérification
if (!$lesInformations) {
    echo "<article>";
    echo ("Échec de la requete : " . $mysqli->error);
    echo ("<p>Vérifiez la requete  SQL suivante dans phpmyadmin<code>$laQuestionEnSql</code></p>");
    echo ("</article>");
    exit();
}


// Boucle while pour création d'article 
while ($post = $lesInformations->fetch_assoc()) {
    ?>
    <article>
        <h3>
            <time><?php echo $post['created'] ?></time>
        </h3>
        <address><?php echo $post['author_name'] ?></address>
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




