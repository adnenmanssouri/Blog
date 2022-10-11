<?php

use App\Connection;
use App\Model\Category;
use App\Model\Post;
use App\PaginatedQuery;
use App\URL;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connection::getPdo();
$query = $pdo->prepare('SELECT * FROM category WHERE id = :id');
$query->execute(['id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Category::class);

/** @var Category|false */
$category = $query->fetch();

if ($category === false) {
    throw new Exception('Aucune categorie ne correspond a cet ID');
}

if ($category->getSlug() !== $slug) {
    $url = $router->url('category', ['slug' => $category->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ', $url);
}

$title = "Catégorie {$category->getName()}";


$paginatedQuery = new PaginatedQuery(
    "SELECT p.*
    FROM post p
    JOIN post_category pc ON pc.post_id = p.id
    WHERE pc.category_id = {$category->getId()}
    ORDER BY created_at DESC",
    "SELECT COUNT(category_id) FROM post_category where category_id = {$category->getId()}"
);
/** @var Post[] */
$posts = $paginatedQuery->getItems(Post::class);
$link = $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()])
?>

<h1><?= e($title); ?></h1>



<div class="row">
    <?php foreach ($posts as $post) : ?>
        <div class="col-md-3">
            <?php require dirname(__DIR__) . '/post/card.php' ?>
        </div>
    <?php endforeach ?>
</div>

<div class="d-flex justify-content-between my-4">
    <?= $paginatedQuery->previousLink($link) ?>
    <?= $paginatedQuery->nextLink($link) ?>
</div>