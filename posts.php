<?php
$bdd = new PDO("mysql:host=localhost:8889;dbname=blog", "root", "root");
$postQuery = $bdd->query("SELECT * FROM post");
$posts = $postQuery->fetchAll(PDO::FETCH_ASSOC);
if(!$posts){
exit();
}

foreach ($posts as $post) {
    echo "<div class='card'>";
    $stmt = $bdd->prepare("SELECT tags.tag FROM tags
                      INNER JOIN post_tag ON tags.id = post_tag.tag_id
                      WHERE post_tag.post_id = :post_id");
    $stmt->bindParam(':post_id', $post["id"]);
    $stmt->execute();

    $tags = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "<div class='card-header d-flex gap-3 align-items-center'>";
    echo "<h3>" . $post['title'] . "</h3>";
    foreach ($tags as $tag) {
        echo "<a class='' href='#'>#" . $tag . "</a>";
    }
    echo "</div>";
    echo "<p class='card-text p-3'>" . $post['body'] . "</p>";
    echo "</div>";
}