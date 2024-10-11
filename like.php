<?php
session_start();
include 'database/connect.php';

// vérifier si l'utilisateur est connecté
if (!isset($_SESSION['connected_id'])) {
    echo "vous devez être connecté pour aimer un message.";
    exit;
}

// récupérer l'id du post et l'id de l'utilisateur connecté
$user_id = $_SESSION['connected_id'];
$post_id = intval($_POST['post_id']);

// sécuriser les données reçues
$post_id = $mysqli->real_escape_string($post_id);

// vérifier si l'utilisateur a déjà aimé ce message
$checkSql = "SELECT * FROM likes WHERE user_id = $user_id AND post_id = $post_id";
$checkResult = $mysqli->query($checkSql);

// si l'utilisateur a déjà aimé le message
if ($checkResult->num_rows > 0) {
    echo "vous avez déjà aimé ce message.";
} else {
    // sinon, insérer le like dans la base de données
    $insertSql = "INSERT INTO likes (user_id, post_id) VALUES ($user_id, $post_id)";
    if ($mysqli->query($insertSql)) {
        // rediriger vers la page précédente après le like
        header("Location: " . $_SERVER['HTTP_REFERER']); // redirection vers la page précédente
        exit();
    } else {
        // afficher une erreur en cas d'échec de l'ajout du like
        echo "erreur lors de l'ajout du like : " . $mysqli->error;
    }
}
?>