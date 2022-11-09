<?php
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'header.php');

if (!empty($_SESSION['error']) && !empty($_SESSION['error'])) { ?>
    <div class="alert alert-danger"><?= $_SESSION['error'] ?>
    </div><?php } $_SESSION['error'] = '';?>
<?php if (isset($_SESSION['success']) && !empty($_SESSION['success'])) { ?>
    <div class="alert alert-info"><?= $_SESSION['success'] ?>
    </div><?php } $_SESSION['success'] = '';?>

<a href="/user">пользователи</a>
<br>
<a href="/file">файлы</a>
<br>
<a href="/auth">authorization</a>

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'footer.php');
