<?php
require_once './check_login.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $content = $_POST['content'];
        $query = "INSERT INTO posts (content, id_users, created_at) VALUES (:content, :id_users, :created_at)";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':created_at', date('Y-m-d H:i:s'));
        $statement->bindValue(':content', $content);
        $statement->bindValue(':id_users', $user['id']);
        $statement->execute();
        header('Location: index.php');
    } catch (PDOException $e) {
        var_dump($e->getMessage());
        die;
    }
}
?>
<?php require_once './templates/head.php' ?>
<?php require_once './templates/navbar.php' ?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Ajouter un post</h1>
            <form action="add_post.php" method="post">
                <div class="form-group">
                    <label for="content">Contenu</label>
                    <textarea name="content" id="content" class="form-control" maxlength="255" oninput="updateCharacterCount()"></textarea>
                    <small id="characterCount" class="form-text text-muted">0 / 255 caractères</small>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Ajouter</button>
            </form>
        </div>
    </div>
</div>

<script>
    function updateCharacterCount() {
        var textarea = document.getElementById('content');
        var characterCountElement = document.getElementById('characterCount');
        var characterCount = textarea.value.length;
        characterCountElement.textContent = characterCount + ' / 255 caractères';
    }
</script>
<?php require_once './templates/footer.php' ?>