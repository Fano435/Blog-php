<?php
session_start();
require("./components/header.php") ?>
<section class="posts grid row-gap-3 container-sm">
<h1>Mes posts</h1>

<?php
$bdd = new PDO("mysql:host=localhost;dbname=blog", "root", "root");
$myPostStmt = $bdd->prepare("SELECT * FROM post WHERE user_id = :user_id");
$myPostStmt->bindValue(':user_id', $_SESSION["user_id"]);
$myPostStmt->execute();
$myPosts = $myPostStmt->fetchAll(PDO::FETCH_ASSOC);
if(!$myPosts){
exit();
}
foreach ($myPosts as $post) {
    echo "<div class='card'>";
    $stmt = $bdd->prepare("SELECT tags.tag FROM tags
                      INNER JOIN post_tag ON tags.id = post_tag.tag_id
                      WHERE post_tag.post_id = :post_id");
    $stmt->bindParam(':post_id', $post["id"]);
    $stmt->execute();

    $tags = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "<div class='card-header d-flex gap-3 align-items-center'>";
    echo "<form action='update-post.php' class='d-flex align-items-center w-100 justify-content-between' method='POST'>
    <h3>
        <textarea class='bg-transparent' type='text' id='post_title' name='post_title' required>".$post['title']."</textarea>
    </h3>

  <input type='hidden' name='post_id' value=". $post['id'] .">
  
  <button type='submit' class='btn btn-outline-secondary btn-sm' name='update_title'>Change Title</button>
  </form>";

    foreach ($tags as $tag) {
        echo "<a class='' href='#'>#" . $tag . "</a>";
    }
    echo "</div>";
    echo "<div class='card-text p-3 '>

    <form action='update-post.php' class='d-flex align-items-center justify-content-between' method='POST'>

        <textarea class='bg-transparent' type='text' id='post_content' name='post_content' required>".$post['body']."</textarea>

        <input type='hidden' name='post_id' value=". $post['id'] .">
  
        <button type='submit' class='btn btn-outline-secondary btn-sm' name='update_content'>Change</button>
    </form>

    <form action='delete.php' method='post'>
        <input type='hidden' name='postId' value=". $post['id'] .">
        <button name='deleteBtn' class='btn btn-outline-danger btn-sm'>supprimer</button>
    </form></div>";
    echo "</div>";
}?>
</section>
<?php require("./components/footer.php"); ?>


