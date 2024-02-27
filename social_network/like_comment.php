<?php
session_start();
require_once 'connect_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['post_id'];

    if (!empty($post_id)) {

        $query = "SELECT * FROM like_posts WHERE id_posts = :post_id AND id_users = :user_id";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':post_id', $post_id);
        $statement->bindValue(':user_id', $_SESSION['user']['id']);
        $statement->execute();
        $existing_like = $statement->fetch();

        if (!$existing_like) {

            $insert_query = "INSERT INTO like_posts (id_posts, id_users, created_at) VALUES (:post_id, :user_id, NOW())";
            $insert_statement = $pdo->prepare($insert_query);
            $insert_statement->bindValue(':post_id', $post_id);
            $insert_statement->bindValue(':user_id', $_SESSION['user']['id']);
            $insert_statement->execute();
        }
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
