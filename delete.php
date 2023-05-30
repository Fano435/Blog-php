<?php
if (!isset($_POST['postId'])) {
    exit();
}

$postId = $_POST['postId'];

try {
    $bdd = new PDO("mysql:host=localhost;dbname=blog", "root", "root");
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Supprimer les entrées de la table post_tag liées au post
    $deleteTagsQuery = $bdd->prepare("DELETE FROM post_tag WHERE post_id = :postId");
    $deleteTagsQuery->bindValue(':postId', $postId);
    $deleteTagsQuery->execute();

    // Supprimer la ligne de la table post
    $deletePostQuery = $bdd->prepare("DELETE FROM post WHERE id = :postId");
    $deletePostQuery->bindValue(':postId', $postId);
    $deletePostQuery->execute();

    echo "Deleted successfully.";
    header("Location: http://localhost/Blog-php/Blog-php/home.php");
    exit();
} catch (PDOException $e) {
    echo "Failed to delete: " . $e->getMessage();
}
