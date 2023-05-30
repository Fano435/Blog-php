<?php
session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <form action="" method="post">
        <div class="d-grid justify-content-center align-items-center " style="height: 100vh;">
            <label for="tag">Tags :</label>
            <input type="text" autofocus name="tag" class="form-control form-control-lg"><br>
            <label for="post_title">Titre du post</label><br>
            <input type="text" required name="post_title" class="form-control form-control-lg"><br>
            <label for="post_title">Contenue du poste</label><br>
            <input type="text" class="post-content form-control form-control-lg " name="post_content">
            <button type="submit" class="btn btn-primary btn-lg">Poster</button>
        </div>
    </form>
</body>

</html>
<?php
if (!$_POST) {
    exit();
}

$post_title = $_POST["post_title"];
$post_content = $_POST["post_content"];
$tag_name = $_POST["tag"];

$bdd = new PDO("mysql:host=localhost;dbname=blog", "root", "root");

$stmtPost = $bdd->prepare("INSERT INTO post (user_id, title, body) VALUES (:user_id, :post_title, :post_content)");
$stmtPost->bindValue(':user_id', $_SESSION["user_id"]);
$stmtPost->bindValue(':post_title', $post_title);
$stmtPost->bindValue(':post_content', $post_content);
$resultPost = $stmtPost->execute();

$postId = $bdd->lastInsertId();
$strTag = $_POST["tag"];
$tags = explode(" ", $strTag);

foreach ($tags as $tag) {
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

header("Location: http://localhost/Blog-php/Blog-php/userhome.php");
?>