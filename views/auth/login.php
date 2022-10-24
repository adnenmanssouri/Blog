<?php

use App\Connection;
use App\HTML\Form;
use App\Model\User;
use App\Table\Exception\NotFoundException;
use App\Table\UserTable;

$user = new User();
$errors = [];
if (!empty($_POST)) {
    $user->setUsername($_POST['username']);
    $errors['password'] = 'identifiant ou mot de passe incorrect';

    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $table = new UserTable(Connection::getPdo());
    try {
        $u = $table->findByUsername($_POST['username']);
        $u->getPassword();
        $_POST['password'];
        if(password_verify($u->getPassword(), $_POST['password']) === true) {
            session_start();
            $_SESSION['auth'] = $u->getId();
            header('Location: ' . $router->url('admin_posts'));
            exit();
        }
    } catch (NotFoundException $e) {
    }
    }
    
}
$form = new Form($user, $errors);


?>
<h1>Se connecter</h1>

<?php if(isset($_GET['forbidden'])): ?>
<div class="alert alert-danger">
    Vous ne pouvez pas accéder a cette page
</div>
<?php endif ?>

<form action="" method="POST">
    <?= $form->input('username', 'Nom d\'utilisateur'); ?>
    <?= $form->input('password', 'Mot de passe'); ?>
    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>