<?php session_start(); 
require("./components/header.php")
?>

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
    <?php require("footer.php");


 
