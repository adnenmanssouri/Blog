<?php

use App\Auth;
use App\Connection;
use App\Table\PostTable;

Auth::check();


$title = "Administration";
$pdo = Connection::getPdo();
$link = $router->url('admin_posts');
[$posts, $pagination] = (new PostTable($pdo))->findPaginated();

?>

<?php if(isset($_GET['delete'])): ?>
    <div class="alert alert-success">
        L'enregistremnt a bien été supprimé
    </div>
<?php endif ?>
<table class="table">
    <thead>
        <th>#</th>
        <th>Titre</th>
        <th>
            <a href="<?= $router->url('admin_post_new') ?>" class="btn btn-primary">Nouveau</a>
        </th>
    </thead>
    <tbody>
        <tr>
            
            <?php foreach ($posts as $post) : ?>
                <td>#<?= $post->getId() ?></td>
                <td>
                    <a href="<?= $router->url('admin_post', ['id' => $post->getId()]) ?>">
                        <?= e($post->getName()) ?>
                    </a>
                </td>
                <td>
                    <a href="<?= $router->url('admin_post', ['id' => $post->getId()]) ?>" class="btn btn-primary">
                        Editer 
                    </a>
                </td>
                <td>
                    <form action="<?= $router->url('admin_post_delete', ['id' => $post->getId()]) ?>" method="POST"
                    onsubmit="return confirm('Voulez vous vraiment effectuer cette action ?')" style="display: inline;">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
            </form>
                </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

<div class="d-flex justify-content-between my-4">
    <?= $pagination->previousLink($link) ?>
    <?= $pagination->nextLink($link) ?>
</div>