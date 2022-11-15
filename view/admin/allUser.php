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

    <table>
        <tr>
            <td>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Имя</th>
                        <th scope="col">Фамилия</th>
                        <th scope="col">email</th>
                        <th scope="col">дата регистрации</th>
                        <th scope="col">редактировать</th>
                        <th scope="col">удалить</th>
                        <th scope="col">личный кабинет</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <th scope="row"><?= $user['id'] ?></th>
                            <td><?= $user['name'] ?></td>
                            <td><?= $user['surname'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['date_create'] ?></td>
                            <td>
                                <button type="submit" name="editForm" value="<?= $user['id'] ?>">редактировать пользователя
                                </button>
                            </td>
                            <td>
                                <button type="submit" name="delete" value="<?= $user['id'] ?>">удалить пользователя
                                </button>
                            </td>
                            <td>
                                <button type="submit" name="PersonalAreaUser" value="<?= $user['id'] ?>">профиль
                                    пользователя
                                </button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </table>
            </td>
        </tr>
    </table>

    <div class="float-right px-2">
        <form action="/logout" method="get">
            <input type="submit" name="logout" value="Выйти с сайта">
        </form>
    </div>

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'footer.php');
