<?php
require_once './check_login.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {

        $comment = $_POST['comment'];
        $post_id = $_POST['post_id'];

        $query = "INSERT INTO comments (content, id_posts, id_users, created_at) VALUES (:content, :post_id, :user_id, :created_at)";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':content', $comment);
        $statement->bindValue(':post_id', $post_id);
        $statement->bindValue(':user_id', $user['id']);
        $statement->bindValue(':created_at', date('Y-m-d H:i:s'));
        $statement->execute();

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
