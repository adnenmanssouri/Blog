<?php

use App\Connection;
use App\Model\Category;
use App\Table\CategoryTable;
use App\Table\PostTable;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connection::getPdo();
$post = (new PostTable($pdo))->find($id);
(new CategoryTable($pdo))->hydratePosts([$post]);

if ($post->getSlug() !== $slug) {
    $url = $router->url('post', ['slug' => $post->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ', $url);
}

$query = $pdo->prepare('
SELECT c.id, c.slug, c.name 
FROM post_category pc 
JOIN category c ON pc.category_id = c.id 
WHERE pc.post_id = :id');
$query->execute(['id' => $post->getId()]);
$query->setFetchMode(PDO::FETCH_CLASS, Category::class);
/** @var Category[] */
$categories = $query->fetchAll();
?>


<h1><?= e($post->getName()) ?></h1>
<p class="text-muted"><?= $post->getCreatedAt()->format('d F Y') ?></p>
<?php foreach($categories as $k => $category):
    if($k > 0):
        echo ', ';
    endif;
    $category_url = $router->url('category', ['id' => $category->getId(), 'slug' => $category->getSlug()]);
    ?><a href="<?= $category_url ?>"><?= $category->getName() ?></a><?php
endforeach ?>
<p><?= $post->getFormattedContent() ?></p>