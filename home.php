<?php session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Blog homepage</title>
</head>
<body>
    <nav >
        <a class="nav-item" href="/post-form.php">POSTER</a>
        <a class="nav-item" href="#">S'inscrire</a>
        <a class="nav-item" href="/index.php">Se connecter</a>
        <a class="nav-item" href="/my-posts.php">Mes posts</a>
    </nav>
    <section class="posts grid row-gap-3 container-sm">
        <?php require_once("posts.php") ?>
    </section>
</body>
</html>