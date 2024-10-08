<?php

// Connexion à la base de données avec erreur version ARTICLE
$mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
if ($mysqli->connect_errno) {
    echo ("<p>Échec de la connexion : . $mysqli->connect_error </p>");
    echo ("<p>Indice: Vérifiez les parametres de <code>new mysqli(...</code></p>");
    exit();
}