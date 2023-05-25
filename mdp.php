<h1>Changer son mot de passe</h1>
    <form method="post">
        <input type="email" name="mail" placeholder="Adresse mail">
        <input type="password" name="new_password" placeholder="Nouveau mot de passe">
        <button type="submit">Envoyer</button>
    </form>

<?php
if(!$_POST){
    exit();
}

$mail = $_POST["mail"];

$new_password = $_POST["new_password"];
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

$bdd = new PDO("mysql:host=localhost:8889;dbname=blog","root","root");
    
$stmt = $bdd->prepare("UPDATE users SET user_password = :new_password WHERE mail = :mail");
$stmt->bindValue(':new_password', $hashed_password);
$stmt->bindValue(':mail', $mail);
$result = $stmt->execute();

if ($result) {
    echo "Password updated successfully!";
} else {
    echo "Failed to update password.";
}