<?php session_start();
include("./components/header.php");
?>
<section class="posts grid row-gap-3 container-sm">
    <nav class="navbar">
        <a class="nav-item btn btn-link" href="/my-posts.php">Mes posts</a>
        <a class="nav-item btn btn-outline-primary" href="/post-form.php">POSTER</a>
        <div class="auth">
            <a class="nav-item btn btn-primary" href="/index.php">Se connecter</a>
            <a class="nav-item btn btn-primary" href="#">S'inscrire</a>
        </div>
    </nav>
        <?php require_once("posts.php") ?>
</section>
<section class="tags">
    <?php require("tags.php")?>
</section>
<?php require("./components/footer.php");