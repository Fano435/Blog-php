<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Document</title>
</head>

<body class="overflow: hidden" >
<div class="d-grid justify-content-center align-items-center " style="height: 100vh;">
    <form action="" method="POST">
        <label for="email">Email</label>
        <input type="email" placeholder=" Votre adresse e-mail" id="email" name="email" class="form-control form-control-lg" required> <br>

        <label for="username">Nom d'utilisateur</label>
        <input type="text" placeholder="Votre nom d'utilisateur" id="username" name="username" class="form-control form-control-lg" required> <br>

        <label for="password">Mot de passe</label>
        <input type="password" placeholder=" Votre mot de passe" id="password" name="password" minlength="8" class="form-control form-control-lg"  required > <br>

        <label for="birthdate">Date de naissance</label>
        <input type="date" id="birthdate" name="birthdate" class="form-control form-control-lg" style="width: 400px;" required> <br>

        <label for="gender-female">Femme</label>
        <input type="radio" id="gender-female" name="gender" value="female" class="form-check-input"  required>

        <label for="gender-male">Homme</label>
        <input type="radio" id="gender-male" name="gender" value="male" class="form-check-input" required>

        <label for="gender-other">Autre</label>
        <input type="radio" id="gender-other" name="gender" value="other" class="form-check-input" required>

        <script>
            const radioButtons = document.querySelectorAll('input[type="radio"][name="gender"]');
            let previousChecked = null;

            radioButtons.forEach(radioButton => {
                radioButton.addEventListener('click', function() {
                    if (this !== previousChecked) {
                        previousChecked = this;
                    } else {
                        this.checked = false; 
                        previousChecked = null;
                    }
                });
            });
        </script>

        <div class="row">
            <div class="col-md-6 offset-md-3">
            <div class="form-group">
                <button type="submit" name="ok" class="btn btn-primary btn-lg" style="width: 200px; margin-top: 50px;">S'inscrire</button>
            </div>
            </div>
        </div>
    </form>
    </div>

</body>

<?php
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', 'root');
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }


    if (isset($_POST['ok'])) {
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $birthdate = $_POST['birthdate'];
        $gender = strtoupper($_POST['gender'][0]);

        $requete = $bdd->prepare('INSERT INTO users (mail, username, user_password, birthdate, gender) VALUES ( :mail, :username, :user_password, :birthdate, :gender)');
        if ($requete->execute([
            "mail" => $email,
            "username" => $username,
            "user_password" => $hashedPassword,
            "birthdate" => $birthdate,
            "gender" => $gender,
        ])) {
            header("Location: http://localhost:8888/index.php");
        } else {
            $errorInfo = $requete->errorInfo();
            echo "Erreur lors de l'insertion : " . $errorInfo[2];
        }

            }
?>
</html>
