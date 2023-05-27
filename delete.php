<?php
if(!$_POST){
    exit();
    }
$postId = $_POST['postId'];

$bdd = new PDO("mysql:host=localhost:8889;dbname=blog", "root", "root");

$stmt = $bdd->prepare("DELETE FROM post WHERE id = :postId");
$stmt->bindValue(':postId', $postId);
$result = $stmt->execute();

$deleteTagsQuery = $bdd->query("DELETE FROM tags
WHERE id NOT IN (SELECT tag_id FROM post_tag)");
    
if ($result) {
    echo "Deleted successfully.";
    header("Location: http://localhost:8888/home.php");
} else {
    echo "Failed to delete.";
}
