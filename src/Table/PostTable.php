<?php

namespace App\Table;

use App\Model\Post;
use App\PaginatedQuery;

final class PostTable extends Table
{

    protected $table = "post";
    protected $class = Post::class;

    public function findPaginated()
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT * FROM " . $this->table . " ORDER BY created_at DESC",
            "SELECT COUNT(id) FROM " . $this->table,
            $this->pdo
        );
        $posts = $paginatedQuery->getItems($this->class);
        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return [$posts, $paginatedQuery];
    }

    public function findPaginatedForCategory(int $categoryId)
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT p.*
            FROM " . $this->table . " p
            JOIN post_category pc ON pc.post_id = p.id
            WHERE pc.category_id = {$categoryId}
            ORDER BY created_at DESC",
            "SELECT COUNT(category_id) FROM post_category where category_id = {$categoryId}"
        );
        $posts = $paginatedQuery->getItems($this->class);
        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return [$posts, $paginatedQuery];
    }
}
