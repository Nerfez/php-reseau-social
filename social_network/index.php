<?php require_once './check_login.php'; ?>
<?php require_once './templates/head.php'; ?>
<?php require_once './templates/navbar.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Bienvenue <?= $user['first_name'] . ' ' . $user['last_name'] ?></h1>
            <a href="add_post.php" class="btn btn-primary">Ajouter un post</a>
        </div>
        <div class="col-12">
            <h2>Publications</h2>
            <?php
            $query = "SELECT p.*, COUNT(lp.id_posts) AS likes_count 
            FROM posts p 
            LEFT JOIN like_posts lp ON p.id = lp.id_posts 
            GROUP BY p.id 
            ORDER BY p.created_at DESC";
            $statement = $pdo->query($query);
            $statement->execute();
            $posts = $statement->fetchAll();
            foreach ($posts as $post) {

                $userQuery = "SELECT * FROM users WHERE id = :user_id";
                $userStatement = $pdo->prepare($userQuery);
                $userStatement->bindValue(':user_id', $post['id_users']);
                $userStatement->execute();
                $postUser = $userStatement->fetch();

                $commentQuery = "SELECT * FROM comments WHERE id_posts = :post_id ORDER BY created_at ASC";
                $commentStatement = $pdo->prepare($commentQuery);
                $commentStatement->bindValue(':post_id', $post['id']);
                $commentStatement->execute();
                $comments = $commentStatement->fetchAll();

            ?>
                <div class="card my-4">
                    <div class="card-body">
                        <h5 class="card-title"><?= $postUser['first_name'] . ' ' . $postUser['last_name'] ?></h5>
                        <p><?= $post['content'] ?></p>
                        <small>Publié le <?= $post['created_at'] ?></small>
                        <small>Nombre de likes : <?= $post['likes_count'] ?></small>

                        <div class="d-flex justify-content-end align-items-center">

                            <form action="like_comment.php" method="post" class="mr-2">
                                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                                <button type="submit" class="btn btn-danger">Like</button>
                            </form>

                            <form action="follow_user.php" method="post">
                                <input type="hidden" name="user_id" value="<?= $postUser['id'] ?>">
                                <button type="submit" class="btn btn-success">Suivre</button>
                            </form>

                        </div>

                        <div class="comments card">
                            <?php foreach ($comments as $comment) : ?>
                                <div class="comment mb-4">
                                    <?php
                                    $commentUserQuery = "SELECT * FROM users WHERE id = :comment_user_id";
                                    $commentUserStatement = $pdo->prepare($commentUserQuery);
                                    $commentUserStatement->bindValue(':comment_user_id', $comment['id_users']);
                                    $commentUserStatement->execute();
                                    $commentUser = $commentUserStatement->fetch();
                                    ?>
                                    <h5 class="card-title"><?= $commentUser['first_name'] . ' ' . $commentUser['last_name'] ?></h5>
                                    <p><?= $comment['content'] ?></p>
                                    <small>Commentaire ajouté le <?= $comment['created_at'] ?></small>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <form action="add_comment.php" method="post">
                            <div class="form-group">
                                <textarea name="comment" class="form-control" placeholder="Ajouter un commentaire"></textarea>
                                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Ajouter un commentaire</button>
                        </form>

                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<?php require_once './templates/footer.php'; ?>