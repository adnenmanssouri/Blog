<!doctype html>
<html lang="en" class="h-100">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <title><?= isset($title) ? e($title) : 'Mon Site' ?></title>
</head>

<body class="d-flex flex-column h-100">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a href="#" class="navbar-brand">
      Mon site
    </a>
    <ul class="navbar-brand">
      <li class="nav-item">
        <a href="<?= $router->url('admin_posts'); ?>" class="navbar-brand">Articles</a>
      </li>
      <li class="nav-item">
        <a href="<?= $router->url('admin_categories'); ?>" class="navbar-brand">Catégories</a>
      </li>
      <li class="nav-item">
        <form action="<?= $router->url('logout') ?>" method="post" style="display:inline">
          <button type="submit" class="nav-link" style="background:transparent; border:none">Se déconnecter</button>  
        </form>
      </li>
    </ul>

  </nav>

  <div class="container mt-4">
    <?= $content ?>
  </div>
  <footer class="bg-light py-4 footer mt-auto">
    <div class="container">
      <?php if (defined('DEBUG_TIME')) : ?>
        Page génerée en <?= round(1000 * (microtime(true) - DEBUG_TIME)) ?> ms
      <?php endif ?>
    </div>
  </footer>
</body>

</html>