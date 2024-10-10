<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Inscription</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php include 'header.php'; ?>

    <div id="wrapper">

        <aside>
            <h2>Présentation</h2>
            <p>Bienvenue sur notre réseau social.</p>
        </aside>
        <main>
            <article>
                <h2>Inscription</h2>
                <?php

                // Etape 2: récupérer ce qu'il y a dans le formulaire @todo: c'est là que votre travaille se situe
                if (isset($_POST['email'])) {

                    $new_email = $_POST['email'];
                    $new_alias = $_POST['pseudo'];
                    $new_passwd = $_POST['motpasse'];

                    //Etape 3 : Ouvrir une connexion avec la base de donnée.
                    include 'connect.php';

                    //Etape 4 : Petite sécurité
                    // pour éviter les injection sql : https://www.w3schools.com/sql/sql_injection.asp
                    $new_email = $mysqli->real_escape_string($new_email);
                    $new_alias = $mysqli->real_escape_string($new_alias);
                    $new_passwd = $mysqli->real_escape_string($new_passwd);


                    // on crypte le mot de passe pour éviter d'exposer notre utilisatrice en cas d'intrusion dans nos systèmes
                    $new_passwd = md5($new_passwd);

                    //Etape 5 : construction de la requete
                    $sql = "INSERT INTO users (id, email, password, alias) 
                            VALUES (NULL, '$new_email', '$new_passwd', '$new_alias')";

                    // Etape 6: exécution de la requete
                    if ($mysqli->query($sql)) {
                        echo "Votre inscription est un succès, $new_alias !";
                        echo " <a href='login.php'>Connectez-vous.</a>";
                    } else {
                        echo "L'inscription a échoué : " . $mysqli->error;
                    }
                }
                ?>


                <form action="registration.php" method="post">
                    <dl>
                        <dt><label for="pseudo">Pseudo</label></dt>
                        <dd><input type="text" name="pseudo" required></dd>
                        <dt><label for="email">E-Mail</label></dt>
                        <dd><input type="email" name="email" required></dd>
                        <dt><label for="motpasse">Mot de passe</label></dt>
                        <dd><input type="password" name="motpasse" required></dd>
                    </dl>
                    <input type="submit" value="S'inscrire">
                </form>
            </article>
        </main>
    </div>
</body>

</html>