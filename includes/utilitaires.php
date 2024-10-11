<?php

//Variable que la requete se fasse dans notre base de données avec condition d'erreur
$lesInformations = $mysqli->query($laQuestionEnSql);
// Vérification
if (!$lesInformations) {
    echo ("<p>Échec de la requete :  . $mysqli->error </p>");
    echo ("<p>Vérifiez la requete  SQL suivante dans phpmyadmin<code>$laQuestionEnSql</code></p>");
    exit();
}
;










