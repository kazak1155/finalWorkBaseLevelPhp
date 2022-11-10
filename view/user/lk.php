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
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
    <table class="table table-bordered">
        <tr>
            <td>
                 <p class="h5">name</p>
            </td>
            <td>
                <p><?= $user['name'] ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="h5">surname</p>
            </td>
            <td>
                <p><?= $user['surname'] ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="h5">email</p>
            </td>
            <td>
                <p><?= $user['email'] ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="h5">date_create</p>
            </td>
            <td>
                <p><?= $user['date_create'] ?></p>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <form action="/auth" method="post">
                    <input type="submit" name="logout" value="Выйти с сайта">
                </form>
            </td>
        </tr>
    </table>

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'footer.php');
