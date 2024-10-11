<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Inscription</title>
    <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div id="wrapper">

        <aside>
            <h2>Présentation</h2>
            <p>Bienvenue sur notre réseau social.</p>
        </aside>
        <main>
            <article>
                <h2>Inscription</h2>
                <?php
                // Etape 2: récupérer ce qu'il y a dans le formulaire
                if (isset($_POST['email'])) {

                    $new_email = $_POST['email'];
                    $new_alias = $_POST['pseudo'];
                    $new_passwd = $_POST['motpasse'];

                    // Etape 3 : Ouvrir une connexion avec la base de donnée.
                    include 'database/connect.php';

                    // Etape 4 : Petite sécurité pour éviter les injections SQL
                    $new_email = $mysqli->real_escape_string($new_email);
                    $new_alias = $mysqli->real_escape_string($new_alias);
                    $new_passwd = $mysqli->real_escape_string($new_passwd);

                    // On crypte le mot de passe pour la sécurité
                    $new_passwd = md5($new_passwd);

                    // Etape 5 : construction de la requête
                    $sql = "INSERT INTO users (id, email, password, alias) 
                            VALUES (NULL, '$new_email', '$new_passwd', '$new_alias')";

                    // Etape 6: exécution de la requête
                    if ($mysqli->query($sql)) {
                        echo "Votre inscription est un succès, $new_alias !";
                        echo " <a href='login.php'>Connectez-vous.</a>";
                    } else {
                        echo "L'inscription a échoué : " . $mysqli->error;
                    }
                }
                ?>

                <!-- formulaire d'inscription -->
                <form action="registration.php" method="post">
                    <dl>
                        <dt><label for='pseudo'>Pseudo</label></dt>
                        <dd><input type='text' id='pseudo' name='pseudo' aria-describedby='pseudoHelp' required></dd>
                        <dd><small id="pseudoHelp">Votre pseudo doit comporter au moins 3 caractères.</small></dd>

                        <dt><label for='email'>E-Mail</label></dt>
                        <dd><input type='email' id='email' name='email' aria-describedby='emailHelp' required></dd>
                        <dd><small id='emailHelp'>Entrez une adresse e-mail valide.</small></dd>

                        <dt><label for='motdepasse'>Mot de passe</label></dt>
                        <dd><input type='password' id='motdepasse' name='motdepasse' aria-describedby='passwordHelp'
                                required></dd>
                        <dd><small id='passwordHelp'>Votre mot de passe doit contenir au moins 8 caractères.</small>
                        </dd>
                    </dl>

                    <!-- consentement -->
                    <p>
                        <input type="checkbox" id="consentement" name="consentement" required>
                        <label for="consentement">J'accepte que mes données soient stockées conformément à la <a
                                href="RGPD/politique-confidentialite.html" target="_blank">politique de
                                confidentialité</a>.
                        </label>
                    </p>

                    <!-- droits utilisateurs -->
                    <p>
                        Vous avez le droit d'accéder, de modifier ou de supprimer vos données à tout moment. Pour plus
                        d'informations, veuillez consulter notre <a href="RGPD/droits-utilisateurs.html"
                            target="_blank">politique de gestion des données personnelles</a>.
                    </p>

                    <input type="submit" value="S'inscrire">
                </form>

            </article>
        </main>
    </div>
</body>

</html>