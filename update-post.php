<?php

$bdd = new PDO("mysql:host=localhost:8889;dbname=blog", "root", "root");

if (isset($_POST['update_title'])){

    $post_id = $_POST['post_id'];
    $new_title =$_POST['post_title'];
    
    $stmt = $bdd->prepare("UPDATE post SET title = :title_post WHERE id = :post_id");
    $stmt->bindValue(':post_id', $post_id);
    $stmt->bindValue(':title_post', $new_title);
    $result = $stmt->execute();
        
    if ($result) {
        header("Location: http://localhost:8888/my-posts.php");
    } else {
        echo "Failed to update title";
    }
} elseif (isset($_POST['update_content'])){
    $post_id = $_POST['post_id'];
    $new_content =$_POST['post_content'];
    
    $stmt = $bdd->prepare("UPDATE post SET body = :content WHERE id = :post_id");
    $stmt->bindValue(':post_id', $post_id);
    $stmt->bindValue(':content', $new_content);
    $result = $stmt->execute();
        
    if ($result) {
        header("Location: http://localhost:8888/my-posts.php");
    } else {
        echo "Failed to update title";
    }
}

