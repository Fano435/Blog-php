<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class="container-sm form">
        <form method="post">
            <div class="mb-3">
                <label for="mail" class="form-label">Adresse email</label><br>
                <input type="email" required name="mail">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label><br>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-light">Se connecter</button>
        </form>
    
        <a href="/mdp.php" class="link-light">Modifiez votre mot de passe</a><br>

    <?php
    if(!$_POST){
        exit();
    }
    $mail = $_POST["mail"];
    $password = $_POST["password"];

    $bdd = new PDO("mysql:host=localhost:8889;dbname=blog","root","root");
    
    $stmt = $bdd->prepare("SELECT * FROM users WHERE mail = :mail");
    $stmt->execute(["mail" => $mail]);
    
    if($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        if(password_verify($password, $result["user_password"])){
            echo "successfully connected";
            $_SESSION["username"] = $result["username"];
            $_SESSION["user_id"] = $result["id"];
            header("Location: http://localhost:8888/home.php");
exit();
        }
    }
   echo "<span class='error'> Mail or password isn't correct </span>";

    ?>
    </div>
</body>
</html>


 
