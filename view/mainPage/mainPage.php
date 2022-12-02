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
if (isset($_SESSION['registration'])) {
    var_dump($_SESSION['registration']);
} ?>

    <h2><?= $status ?></h2>
    <table>
        <tr>
            <td>
                <a href="<?= $personalData ?>">личный кабинет</a>
            </td>
        </tr>

        <?php foreach ($menu as $menu1): ?>

            <tr>
                <td>
                    <a href="<?= $menu1['path'] ?>"><?= $menu1['name_link'] ?></a>
                </td>
            </tr>

        <?php endforeach ?>
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
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'footer.php');
