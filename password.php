<?php session_start(); 
require("./components/header.php")
?>

    <div class="container-sm form">
        <form method="post">
            <div class="d-grid justify-content-center align-items-center " style="height: 70vh;">
                <label for="mail" class="form-label">Adresse email</label><br>
                <input type="email" class="form-control form-control-lg" required name="mail">
                <label for="password" >Mot de passe</label><br>
                <input type="password" class="form-control form-control-lg" name="password" required>
                <button type="submit"  class="btn btn-primary btn-lg">Se connecter</button>
                <a href="http://localhost/Blog-php/Blog-php/mdp.php" class="btn-primary">Modifiez votre mot de passe</a><br>
            </div>
        </form>
    

    <?php
    if(!$_POST){
        exit();
    }
    $mail = $_POST["mail"];
    $password = $_POST["password"];

    $bdd = new PDO("mysql:host=localhost;dbname=blog","root","root");
    
    $stmt = $bdd->prepare("SELECT * FROM users WHERE mail = :mail");
    $stmt->execute(["mail" => $mail]);
    
    if($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        if(password_verify($password, $result["user_password"])){
            echo "successfully connected";
            $_SESSION["username"] = $result["username"];
            $_SESSION["user_id"] = $result["id"];
            header("Location: http://localhost/Blog-php/Blog-php/userhome.php");
exit();
        }
    }
   echo "<span class='error'> Mail or password isn't correct </span>";

    ?>
    </div>



 
