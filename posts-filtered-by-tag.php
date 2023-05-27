<?php
if (!$_POST) {
    exit();
}

$selected_tag_id = $_POST['tag'];
$bdd = new PDO("mysql:host=localhost:8889;dbname=blog", "root", "root");

$filter_stmt = $bdd->prepare("SELECT DISTINCT post.*
FROM post
INNER JOIN post_tag ON post.id = post_tag.post_id
INNER JOIN tags ON post_tag.tag_id = tags.id
WHERE tags.id = :selected_tag_id
");
$filter_stmt->bindValue(":selected_tag_id", $selected_tag_id);
$filter_stmt->execute();
$filtered_posts = $filter_stmt->fetchAll(PDO::FETCH_ASSOC);


echo "<h1>". $selected_tag_id. "</h1>";

foreach($filtered_posts as $post){
    echo "<div class='card'>";
    echo "<div class='card-header d-flex gap-3 align-items-center'>";
    echo "<h3>" . $post['title'] . "</h3>";
    echo "</div>";
    echo "<p class='card-text p-3'>" . $post['body'] . "</p>";
    echo "</div>";
}
?>