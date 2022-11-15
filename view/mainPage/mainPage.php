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
        <tr>
            <td>
                <a href="/createUser">создать нового пользователя</a>
            </td>
        </tr>
        <tr>
            <td>
                <br><br>
                <form action="/logout" method="get">
                    <input type="submit" name="logout" value="Выйти с сайта">
                </form>
            </td>
        </tr>
    </table>
    <?php
} elseif ($_SESSION['status_user'] == 'user') {
    ?>
    <br>
    <a href="/user/<?= $_SESSION['userId'] ?>">личный кибинет</a>
    <br>
    <a href="/file">мои файлы</a>
    <br><br>
    <form action="/logout" method="get">
        <input type="submit" name="logout" value="Выйти с сайта">
    </form>
<?php } else {
    header('Location: /login');
}
?>

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'footer.php');
