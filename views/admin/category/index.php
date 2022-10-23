<?php

use App\Auth;
use App\Connection;
use App\Table\CategoryTable;

Auth::check();

$title = "Gestion des catégories";
$pdo = Connection::getPdo();
$link = $router->url('admin_categories');
$items = (new CategoryTable($pdo))->all();

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
        <th>URL</th>
        <th>
            <a href="<?= $router->url('admin_category_new') ?>" class="btn btn-primary">Nouveau</a>
        </th>
    </thead>
    <tbody>
        <tr>
            
            <?php foreach ($items as $item) : ?>
                <td>#<?= $item->getId() ?></td>
                <td><?= e($item->getSlug()) ?></td>
                <td>
                    <a href="<?= $router->url('admin_category', ['id' => $item->getId()]) ?>">
                        <?= e($item->getName()) ?>
                    </a>
                </td>
                <td>
                    <a href="<?= $router->url('admin_category', ['id' => $item->getId()]) ?>" class="btn btn-primary">
                        Editer 
                    </a>
                </td>
                <td>
                    <form action="<?= $router->url('admin_category_delete', ['id' => $item->getId()]) ?>" method="POST"
                    onsubmit="return confirm('Voulez vous vraiment effectuer cette action ?')" style="display: inline;">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
            </form>
                </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>