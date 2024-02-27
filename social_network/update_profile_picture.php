<?php
session_start();

require_once 'connect_db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['profile_picture_url'])) {

    $new_profile_picture_url = $_POST['profile_picture_url'];

    $user_id = $_SESSION['user']['id'];

    $update_query = "UPDATE users SET photo = :profile_picture_url WHERE id = :user_id";
    $update_statement = $pdo->prepare($update_query);
    $update_statement->execute(array(':profile_picture_url' => $new_profile_picture_url, ':user_id' => $user_id));

    header('Location: profile.php');
    exit();
} else {
    header('Location: profile.php');
    exit();
}
