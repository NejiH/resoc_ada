<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Inscription</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
    <?php
    include 'database/connect.php';
    include 'includes/header.php';
    ?>

    <div id="wrapper">

        <aside>
            <h2>Présentation</h2>
            <p>Bienvenu sur notre réseau social.</p>
        </aside>
        <main>
            <article>
                <h2>Inscription</h2>
                <?php
                /**
                 * TRAITEMENT DU FORMULAIRE
                 */
                // Etape 1 : vérifier si on est en train d'afficher ou de traiter le formulaire
                // si on recoit un champs email rempli il y a une chance que ce soit un traitement
                $enCoursDeTraitement = isset($_POST['email']);
                if ($enCoursDeTraitement) {
                    // on ne fait ce qui suit que si un formulaire a été soumis.
                    // Etape 2: récupérer ce qu'il y a dans le formulaire @todo: c'est là que votre travaille se situe
                    // observez le résultat de cette ligne de débug (vous l'effacerez ensuite)
                    // echo "<pre>" . print_r($_POST, 1) . "</pre>";
                    // et complétez le code ci dessous en remplaçant les ???
                    $new_email = $_POST['email'];
                    $new_alias = $_POST['pseudo'];
                    $new_passwd = $_POST['motdepasse'];


                    //Etape 3 : Ouvrir une connexion avec la base de donnée.
                    //Etape 4 : Petite sécurité
                    // pour éviter les injection sql : https://www.w3schools.com/sql/sql_injection.asp
                    $new_email = $mysqli->real_escape_string($new_email);
                    $new_alias = $mysqli->real_escape_string($new_alias);
                    $new_passwd = $mysqli->real_escape_string($new_passwd);
                    // on crypte le mot de passe pour éviter d'exposer notre utilisatrice en cas d'intrusion dans nos systèmes
                    $new_passwd = md5($new_passwd);
                    // NB: md5 est pédagogique mais n'est pas recommandée pour une vraies sécurité
                    //Etape 5 : construction de la requete
                    $lInstructionSql = "INSERT INTO users (id, email, password, alias) "
                        . "VALUES (NULL, "
                        . "'" . $new_email . "', "
                        . "'" . $new_passwd . "', "
                        . "'" . $new_alias . "'"
                        . ");";
                    // Etape 6: exécution de la requete
                    $ok = $mysqli->query($lInstructionSql);
                    if (!$ok) {
                        echo "L'inscription a échouée : " . $mysqli->error;
                    } else {
                        echo "Votre inscription est un succès : " . $new_alias;
                        echo " <a href='login.php'>Connectez-vous.</a>";
                    }
                }
                ?>
                <!-- formulaire d'inscription -->
                <form action="registration.php" method="post" aria-labelledby="registrationForm">
                    <dl>
                        <dt><label for='pseudo'>Pseudo</label></dt>
                        <dd><input type='text' id='pseudo' name='pseudo' aria-describedby='pseudoHelp'
                                placeholder="Pseudo" minlength=3 required></dd>
                        <dd><small id="pseudoHelp">Votre pseudo doit comporter au moins 3 caractères.</small></dd>
                        <dt><label for='email'>E-Mail</label></dt>
                        <dd><input type="email" id="email" name="email" placeholder="Email" required></dd>
                        <dd><small id='emailHelp'>Entrez une adresse e-mail valide.</small></dd>
                        <dt><label for='motdepasse'>Mot de passe</label></dt>
                        <dd><input type='password' placeholder="Mot de Passe" id='motdepasse' name='motdepasse'
                                aria-describedby='passwordHelp' minlength=8 required></dd>
                        <dd><small id='passwordHelp'>Votre mot de passe doit contenir au moins 8 caractères.</small>
                        </dd>
                    </dl>
                    <p>
                        <input type="checkbox" id="consent" name="consent" required>
                        <label for="consent">J'autorise l'utilisation de mes données conformément aux <u><a
                                    href="RGPD/politique-confidentialite.html" target="_blank">termes de la politique de
                                    confidentialité</a></u>.

                        </label>
                    </p>
                    <br>
                    <p>
                        Vous pouvez à tout moment consulter, modifier ou supprimer vos données
                        personnelles.<br>Consultez
                        notre <u><a href="RGPD/droits-utilisateurs.html" target="_blank">politique de protection des
                                données pour plus de détails</a></u>.
                    </p><br>
                    <input type='submit' value="Submit" />
                </form>
            </article>
        </main>
    </div>
</body>

</html>