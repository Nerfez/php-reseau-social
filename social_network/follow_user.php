<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

require_once 'connect_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_id_to_follow = $_POST['user_id'];


    $current_user_id = $_SESSION['user']['id'];

    if ($user_id_to_follow != $current_user_id) {

        $query = "SELECT * FROM followers WHERE id_users = :current_user_id AND id_users_is_followed = :user_id_to_follow";
        $statement = $pdo->prepare($query);
        $statement->execute(array(':current_user_id' => $current_user_id, ':user_id_to_follow' => $user_id_to_follow));
        $existing_follow = $statement->fetch();

        if (!$existing_follow) {

            $query = "INSERT INTO followers (created_at, id_users, id_users_is_followed) VALUES (NOW(), :current_user_id, :user_id_to_follow)";
            $statement = $pdo->prepare($query);
            $statement->execute(array(':current_user_id' => $current_user_id, ':user_id_to_follow' => $user_id_to_follow));
        }
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
