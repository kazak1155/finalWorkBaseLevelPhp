<?php
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'header.php');

if (!empty($_SESSION['error']) && !empty($_SESSION['error'])) { ?>
    <div class="alert alert-danger"><?= $_SESSION['error'] ?>
    </div><?php }
$_SESSION['error'] = ''; ?>
<?php if (isset($_SESSION['success']) && !empty($_SESSION['success'])) { ?>
    <div class="alert alert-info"><?= $_SESSION['success'] ?>
    </div><?php }
$_SESSION['success'] = ''; ?>
<?php
if ($_SESSION['status_user'] == 'administrator') {
    ?>

    <table>
        <tr>
            <td>
                <a href="/user/<?= $_SESSION['userId'] ?>">личный кибинет</a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="/user">все пользователи</a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="/file">файлы</a>
            </td>
        </tr>
    </table>
    <br>
    <div class="float-right px-2">
        <form action="/auth" method="post">
            <input class="btn btn-dark" type="submit" name="logout" value="Выйти с сайта">
        </form>
    </div>

    <?php
} elseif ($_SESSION['status_user'] == 'user') {
    ?>

    <table>
        <tr>
            <td>
                <a href="/user/<?= $_SESSION['userId'] ?>">личный кибинет</a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="/file/<?= $_SESSION['userId'] ?>">мои файлы</a>
            </td>
        </tr>
    </table>
    <br>
    <div class="float-right px-2">
        <form action="/auth" method="post">
            <input class="btn btn-dark" type="submit" name="logout" value="Выйти с сайта">
        </form>
    </div>

<?php } else {
    header('Location: /auth');
}
?>

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'footer.php');
