<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Changer de mot de passe</title>
</head>

<body>
    <h1>Changer son mot de passe</h1>
    <form method="post">
        <div class="d-grid justify-content-center align-items-center" style="height: 100vh;">
            <input type="email" name="mail" placeholder="Adresse mail" class="form-control form-control-lg">
            <input type="password" name="new_password" placeholder="Nouveau mot de passe" class="form-control form-control-lg">
            <button type="submit" class="btn btn-primary btn-lg">Envoyer</button>
        </div>
    </form>
</body>

</html>


<?php
if (!$_POST) {
    exit();
}

$mail = $_POST["mail"];

$new_password = $_POST["new_password"];
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

$bdd = new PDO("mysql:host=localhost;dbname=blog", "root", "root");

$stmt = $bdd->prepare("UPDATE users SET user_password = :new_password WHERE mail = :mail");
$stmt->bindValue(':new_password', $hashed_password);
$stmt->bindValue(':mail', $mail);
$result = $stmt->execute();

if ($result) {
    echo "Password updated successfully!";
} else {
    echo "Failed to update password.";
}
