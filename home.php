<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Blog homepage</title>
</head>
<body>
    <h1>I am the homepage</h1>
    <form action="" method="post">
        <label for="tag">Tags :</label> 
        <input type="text" autofocus name="tag"> 
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
    
    if (!$resultPost) {
        echo "Failed to post.";
        exit();
    }
    
    $postId = $bdd->lastInsertId();
    
    $stmtTag = $bdd->prepare("INSERT INTO tags (tag) VALUES (:tag_name)");
    $stmtTag->bindValue(':tag_name', $tag_name);
    $resultTag = $stmtTag->execute();
    
    if (!$resultTag) {
        echo "Failed to post.";
        exit();
    }

    $tagId = $bdd->lastInsertId();
    

    $stmtPostTag = $bdd->prepare("INSERT INTO post_tag (post_id, tag_id) VALUES (:post_id, :tag_id)");
    $stmtPostTag->bindValue(':post_id', $postId);
    $stmtPostTag->bindValue(':tag_id', $tagId);
    $resultPostTag = $stmtPostTag->execute();
    
    if ($resultPostTag) {
        echo "Posted!";
    } else {
        echo "Failed to post.";
    }
    
    
    ?>
    <article class="post">
        <span class="username"></span>
        <span class="tag"></span>
        <h3 class="post-title"></h3>
        <p class="post-content"></p>
    </article>
</body>
</html>