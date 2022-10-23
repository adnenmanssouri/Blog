<?php

use App\Auth;
use App\Connection;
use App\HTML\Form;
use App\ObjectHelper;
use App\Table\CategoryTable;
use App\Table\PostTable;
use App\Validators\PostValidator;

Auth::check();

$pdo = Connection::getPdo();
$postTable = new PostTable($pdo);
$categoryTable = new CategoryTable($pdo);
$categories = $categoryTable->list();
$post = $postTable->find($params['id']);
$categoryTable->hydratePosts([$post]);
$success = false;

$errors = [];

if (!empty($_POST)) {
    $v = new PostValidator($_POST, $postTable, $post->getId(), $categories);
    ObjectHelper::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at', ]);
    if ($v->validate()) {
        $pdo->beginTransaction();
        $postTable->updatePost($post);
        $postTable->attachCategories($post->getId(), $_POST['categories_ids']);
        $pdo->commit();
        $categoryTable->hydratePosts([$post]);
        $success = true;
    } else {
        $errors = $v->errors();
    }
}

$form = new Form($post, $errors);
?>


<?php if ($success) : ?>
    <div class="alert alert-success">
        L'article a bien été modifié
    </div>
<?php endif ?>

<?php if (isset($_GET['created'])) : ?>
    <div class="alert alert-success">
        L'article a bien été crée
    </div>
<?php endif ?>

<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">
        L'article ne pas pu etre modifié, merci de corriger vos erreurs
    </div>
<?php endif ?>

<h1>Editer l'article <?= e($post->getName()) ?></h1>

<?php require('_form.php');