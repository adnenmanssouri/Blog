<?php

use App\Auth;
use App\Connection;
use App\HTML\Form;
use App\Model\Post;
use App\ObjectHelper;
use App\Table\CategoryTable;
use App\Table\PostTable;
use App\Validators\PostValidator;

Auth::check();

$errors = [];
$post = new Post();
$pdo = Connection::getPdo();
$categoryTable = new CategoryTable($pdo);
$categories = $categoryTable->list();
$post->setCreatedAt(date('Y-m-d H:i:s'));

if (!empty($_POST)) {
    $postTable = new PostTable($pdo);

    $v = new PostValidator($_POST, $postTable, $post->getId(), $categories);
    ObjectHelper::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at',]);
    if ($v->validate()) {
        $pdo->beginTransaction();
        $postTable->createPost($post);
        $postTable->attachCategories($post->getId(), $_POST['categories_ids']);
        $pdo->commit();
        header('Location: ' . $router->url('admin_post', ['id' => $post->getId()]) . '?created=1');
        exit();
    } else {
        $errors = $v->errors();
    }
}

$form = new Form($post, $errors);
?>

<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">
        L'article ne pas pu etre enregistré, merci de corriger vos erreurs
    </div>
<?php endif ?>

<h1>Créer un article</h1>

<?php require('_form.php');