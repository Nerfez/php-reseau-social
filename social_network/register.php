<?php
require_once './connect_db.php';
if (isset($_SESSION['user'])) {
    header('Location: index.php');
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (empty($last_name) || empty($first_name) || empty($email) || empty($birthday) || empty($username) || empty($password)) {
        $error = 'Tous les champs sont obligatoires';
    } else {
        try {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (last_name, first_name, email, birthday, username, password) VALUES (:last_name, :first_name, :email, :birthday, :username, :password)";
            $statement = $pdo->prepare($query);
            $statement->bindValue(':last_name', $last_name);
            $statement->bindValue(':first_name', $first_name);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':birthday', $birthday);
            $statement->bindValue(':username', $username);
            $statement->bindValue(':password', $password);
            $statement->execute();

            $id = $pdo->lastInsertId();
            $query = "SELECT * FROM users WHERE id = :id";
            $statement = $pdo->prepare($query);
            $statement->bindValue(':id', $id);
            $statement->execute();
            $user = $statement->fetch();
            session_start();
            $_SESSION['user'] = $user;

            header('Location: index.php');
            exit();
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            die;
            $error = 'Erreur lors de l\'inscription';
        }
    }
}
require_once './templates/head.php';
?>

<div class="container">
    <h1>Inscription</h1>
    <div class="error">
        <?php
        if (isset($error)) {
            echo $error;
        }
        ?>
    </div>
    <form action="register.php" method="post" class="mt-3">
        <div class="form-group">
            <label for="last_name">Nom</label>
            <input type="text" name="last_name" id="last_name" class="form-control">
        </div>
        <div class="form-group">
            <label for="first_name">Prénom</label>
            <input type="text" name="first_name" id="first_name" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="birthday">Date de naissance</label>
            <input type="date" name="birthday" id="birthday" class="form-control">
        </div>
        <div class="form-group">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" name="username" id="username" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary mt-3">S'inscrire</button>
    </form>
    <a href="login.php">Retour</a>
</div>
<?php

require_once './templates/footer.php';

?>