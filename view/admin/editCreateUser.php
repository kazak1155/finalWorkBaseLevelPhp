<?php
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'header.php');
?>

<?php if (!empty($_SESSION['error']) && !empty($_SESSION['error'])) { ?>
    <div class="alert alert-danger"><?= $_SESSION['error'] ?>
    </div><?php }
$_SESSION['error'] = ''; ?>
<?php if (isset($_SESSION['success']) && !empty($_SESSION['success'])) { ?>
    <div class="alert alert-info"><?= $_SESSION['success'] ?>
    </div><?php }
$_SESSION['success'] = ''; ?>

<?php

$path = explode("/", $_SERVER['REQUEST_URI']);

if ($path[1] == 'createUser') { ?>

createUser

    <table>
        <tr>
            <td>
                <form action="/createUser" method="post">
                    <div>
                        <label for="email">enter Email:</label>
                        <input type="email" id="email" name="email" />
                    </div>
                    <button type="submit">knopka</button>
                </form>
            </td>
        </tr>
        <tr>
            <td>
                <form action="/auth" method="post">
                    <input type="submit" name="logout" value="Выйти с сайта">
                </form>
            </td>
        </tr>
    </table>
<?php
} else { ?>
editUser
    <table>
        <tr>
            <td>
                <form action="/editUser/<?= $user['id'] ?>" method="get">
                    <div>
                        <label for="email">enter Email:</label>
                        <input type="email" id="email" name="email" />
                    </div>
                </form>
                <button type="submit" name="edit" value="<?= $user['id'] ?>">редактировать пользователя
            </td>
        </tr>
        <tr>
            <td>
                <form action="/auth" method="post">
                    <input type="submit" name="logout" value="Выйти с сайта">
                </form>
            </td>
        </tr>
    </table>

<?php
}
?>


<?php
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'footer.php');
