<?php
session_start();

require_once 'connect_db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user']['id'];

$query = "SELECT * FROM users WHERE id = :user_id";
$statement = $pdo->prepare($query);
$statement->execute(array(':user_id' => $user_id));
$user = $statement->fetch();

$profile_picture = $user['photo'];

if (empty($profile_picture)) {
    $profile_picture = 'https://cdn-icons-png.flaticon.com/512/149/149071.png';
}

$liked_posts_query = "SELECT p.* FROM posts p INNER JOIN like_posts lp ON p.id = lp.id_posts WHERE lp.id_users = :user_id";
$liked_posts_statement = $pdo->prepare($liked_posts_query);
$liked_posts_statement->execute(array(':user_id' => $user_id));
$liked_posts = $liked_posts_statement->fetchAll();

$query_followers = "SELECT u.* FROM followers f INNER JOIN users u ON f.id_users = u.id WHERE f.id_users_is_followed = :user_id";
$statement_followers = $pdo->prepare($query_followers);
$statement_followers->execute(array(':user_id' => $user_id));
$followers = $statement_followers->fetchAll();
?>
<?php require_once './templates/head.php' ?>
<?php require_once './templates/navbar.php' ?>
<!DOCTYPE html>
<html lang="fr">
<style>
    .profile-picture {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 20px;
        border: 1px solid black;
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
</head>

<body>
    <div class="container">
        <h1 class="mb-4">Profil de <?php echo $user['username']; ?></h1>
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">

                    <div class="col-auto">
                        <img src="<?php echo $profile_picture; ?>" alt="Photo de profil" class="profile-picture">

                        <form action="update_profile_picture.php" method="post">
                            <div class="form-group">
                                <label for="profile_picture_url">Nouvelle photo de profil (URL) :</label>
                                <input type="text" class="form-control" id="profile_picture_url" name="profile_picture_url" placeholder="Entrez l'URL de votre nouvelle photo de profil">
                            </div>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </form>

                    </div>

                    <div class="col">
                        <p class="card-text">Prénom : <?php echo $user['first_name']; ?></p>
                        <p class="card-text">Nom : <?php echo $user['last_name']; ?></p>
                        <p class="card-text">Nom d'utilisateur : <?php echo $user['username']; ?></p>
                        <p class="card-text">Email : <?php echo $user['email']; ?></p>
                        <p class="card-text">Date de naissance : <?php echo $user['birthday']; ?></p>
                    </div>

                </div>
            </div>
        </div>

        <h2 class="mb-4">Posts aimés</h2>
        <?php foreach ($liked_posts as $post) : ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Post ID: <?php echo $post['id']; ?></h5>
                    <p class="card-text"><?php echo $post['content']; ?></p>
                    <small class="text-muted">Publié le <?php echo $post['created_at']; ?></small>
                </div>
            </div>
        <?php endforeach; ?>

        <h2 class="mt-4">Mes followers</h2>
        <ul>
            <?php foreach ($followers as $follower) : ?>
                <li><?= $follower['username'] ?></li>
            <?php endforeach; ?>
        </ul>

    </div>
</body>


</html>