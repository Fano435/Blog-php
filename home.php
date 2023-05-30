<?php
session_start();
include("./components/header.php");
?>
<section class="posts grid row-gap-3 container-sm">
    <nav class="navbar">
        <a class="nav-item btn btn-link" href="/Blog-php/Blog-php/homepost.php">Mes posts</a>
        <a class="nav-item btn btn-outline-primary" href="/Blog-php/Blog-php/homepostform.php">POSTER</a>
        <div class="auth">
            <a class="nav-item btn btn-primary" href="/Blog-php/Blog-php/password.php">Se connecter</a>
            <a class="nav-item btn btn-primary" href="/Blog-php/Blog-php/sign_in.php">S'inscrire</a>
        </div>
    </nav>
    <?php
    $bdd = new PDO("mysql:host=localhost;dbname=blog", "root", "root");
    $postQuery = $bdd->query("SELECT * FROM post");
    $posts = $postQuery->fetchAll(PDO::FETCH_ASSOC);
    if (!$posts) {
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

        echo "<form method='POST'>";
        echo "<div class='card'>";
        echo "<div class='input-group mb-3'>";
        echo "<input type='hidden' name='id' value='" . $post['id'] . "'>";
        echo "<div class='input-group-append'>";
        echo "<p class='card-text p-3'>Connectez-vous pour pouvoir commenter un poste</p>";
        echo "</div>";
        echo "</div>";

        if (isset($_POST['bon']) && $_POST['id'] == $post['id']) {
            $user_id = $_SESSION["user_id"];
            $user_comment = $_POST['postId'];
            $post_id = $_POST['id'];

            $requete = $bdd->prepare('INSERT INTO comments (user_id, post_id, user_comment) VALUES (:user_id, :post_id, :user_comment)');
            $requete->execute([
                "user_id" => $user_id,
                "post_id" => $post_id,
                "user_comment" => $user_comment,
            ]);
        }

        $existingCommentsStmt = $bdd->prepare("SELECT * FROM comments WHERE post_id = :post_id");
        $existingCommentsStmt->execute([
            "post_id" => $post['id']
        ]);
        $existingComments = $existingCommentsStmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($existingComments as $comment) {
            echo "<div class='d-flex justify-content-between'>";
            echo "<p class='card-text p-3'>" . $comment['user_comment'] . "</p>";
            echo "<div'>";
            echo "<form method='POST'>";
            echo "<input type='hidden' name='commentId' value='" . $comment['id'] . "'>";
            echo "</form>";
            echo "<small class='card-text p-3'>" . $comment['created_at'] . "</small>";
            echo "</div'>";
            echo "</div>";
        }

        echo "</div>";
        echo "</form>";
    }
    ?>
</section>
<?php require("./components/footer.php");
