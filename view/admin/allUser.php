<?php
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'header.php');
?>

<body>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Имя</th>
            <th scope="col">Фамилия</th>
            <th scope="col">Username</th>
            <th scope="col">email</th>
            <th scope="col">дата регистрации</th>
            <th scope="col">редактировать</th>
            <th scope="col">удалить</th>
        </tr>
        </thead>
        <tbody>
<?php foreach ($users as $user): ?>
        <tr>
            <th scope="row"><?= $user['id'] ?></th>
            <td><?= $user['name'] ?></td>
            <td><?= $user['surname'] ?></td>
            <td><?= $user['password'] ?></td>
            <td><?= $user['email'] ?></td>
            <td><?= $user['date_create'] ?></td>
            <td>
                <button type="submit"  name="edit" value="<?= $user['id'] ?>">редактировать пользователя</button>
            </td>
            <td>
                <button type="submit"  name="delete" value="<?= $user['id'] ?>">удалить пользователя</button>
            </td>
        </tr>
        <br><br><br>
        </tbody>
<?php endforeach ?>
    <button type="submit" class="btn btn-primary btn-md" name="delete" value="1">button 1</button>
    <button type="submit" class="btn btn-primary btn-md" name="delete" value="2">button 2</button>
    <button type="submit" class="btn btn-primary btn-md" name="delete" value="3">button 3</button>

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'footer.php');
