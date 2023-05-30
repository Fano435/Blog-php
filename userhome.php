<?php
session_start();
include("./components/header.php");
?>
<section class="posts grid row-gap-3 container-sm">
    <nav class="navbar">
        <a class="nav-item btn btn-link" href="/Blog-php/Blog-php/my-posts.php">Mes posts</a>
        <a class="nav-item btn btn-outline-primary" href="/Blog-php/Blog-php/post-form.php">POSTER</a>
        <div class="auth">
            <p class="nav-item btn btn-primary"><?php echo $_SESSION["username"] ?></p>
        </div>
    </nav>
    <?php require_once("posts.php"); ?>
</section>
<?php require("./components/footer.php"); ?>
