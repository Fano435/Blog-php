<h1>Mes posts</h1>
<?php
session_start();
$bdd = new PDO("mysql:host=localhost:8889;dbname=blog", "root", "root");
$myPostStmt = $bdd->prepare("SELECT * FROM post WHERE user_id = :user_id");
$myPostStmt->bindValue(':user_id', $_SESSION["user_id"]);
$myPostStmt->execute();
$myPosts = $myPostStmt->fetchAll(PDO::FETCH_ASSOC);
if(!$myPosts){
exit();
}
foreach ($myPosts as $post) {
    echo "<div class='card'>";
    echo "<h3 class='card-header'>" . $post['title'] . "</h3>";
    echo "<p class='card-text p-3'>" . $post['body'] . "</p>";
    echo "</div>";
}