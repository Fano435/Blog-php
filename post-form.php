<?php
session_start()?>
<form action="" method="post">
        <label for="tag">Tags :</label>
        <input type="text" autofocus name="tag"><br> 
        <label for="post_title">Titre du post</label><br>
        <input type="text" required name="post_title"><br>
        <input type="text" class="post-content" name="post_content">
        <button type="submit">Poster</button>
    </form>
<?php
if (!$_POST) {
    exit();
}

$post_title = $_POST["post_title"];
$post_content = $_POST["post_content"];
$tag_name = $_POST["tag"];

$bdd = new PDO("mysql:host=localhost:8889;dbname=blog", "root", "root");
    
$stmtPost = $bdd->prepare("INSERT INTO post (user_id, title, body) VALUES (:user_id, :post_title, :post_content)");
$stmtPost->bindValue(':user_id', $_SESSION["user_id"]);
$stmtPost->bindValue(':post_title', $post_title);
$stmtPost->bindValue(':post_content', $post_content);
$resultPost = $stmtPost->execute();

$postId = $bdd->lastInsertId();    
$strTag = $_POST["tag"];
$tags = explode(" ", $strTag);

foreach($tags as $tag){
    $stmt = $bdd->prepare("INSERT INTO tags (tag) SELECT :tag WHERE NOT EXISTS ( SELECT 1 FROM tags WHERE tag = :tag)");
    
    $stmt->bindParam(':tag', $tag);
    $result = $stmt->execute();

    $getTagId = $bdd->prepare("SELECT tags.id FROM tags WHERE tags.tag = :tag");
    $getTagId->bindParam(':tag', $tag);
    $getTagId->execute();
    $tagId = $getTagId->fetchColumn();
    
    $stmtPostTag = $bdd->prepare("INSERT INTO post_tag (post_id, tag_id) VALUES (:post_id, :tag_id)");
    $stmtPostTag->bindValue(':post_id', $postId);
    $stmtPostTag->bindValue(':tag_id', $tagId);
    $stmtPostTag->execute();
}

header("Location: http://localhost:8888/home.php");
?>