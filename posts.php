<?php
$bdd = new PDO("mysql:host=localhost:8889;dbname=blog", "root", "root");
$postStmt = $bdd->prepare("SELECT * FROM post");
$postStmt->execute();
$posts = $postStmt->fetchAll(PDO::FETCH_ASSOC);
if(!$posts){
exit();
}
foreach ($posts as $post) {
    echo "<div class='card'>";
    echo "<h3 class='card-header'>" . $post['title'] . "</h3>";
    echo "<p class='card-text p-3'>" . $post['body'] . "</p>";
    echo "</div>";
}