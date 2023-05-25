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
        header("Location: http://localhost:8888/home.php");
    } else {
        echo "Failed to post.";
    }

    ?>