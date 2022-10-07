<!doctype html>
<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title><?= $title ?? 'Mon Site' ?></title>
  </head>
  <body class="d-flex flex-column h-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a href="#" class="navbar-brand">
            Mon site
        </a>
    </nav>

    <div class="container mt-4">
        <?= $content ?>
    </div>
    <footer class="bg-light py-4 footer mt-auto">
        <div class="container">
          <?php if (defined('DEBUG_TIME')): ?>
          Page génerée en <?= round(1000 * (microtime(true) - DEBUG_TIME)) ?> ms
          <?php endif ?>
        </div>
    </footer>
  </body>
</html>