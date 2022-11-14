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

    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-6 top-cover center-block">
        <table class="table table-bordered">
            <tr>
                <td>
                    <p class="h5 text-center">имя</p>
                </td>
                <td>
                    <p class="text-center "><?= $user['name'] ?></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="h5 text-center">фамилия</p>
                </td>
                <td>
                    <p class="text-center"><?= $user['surname'] ?></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="h5 text-center">email</p>
                </td>
                <td>
                    <p class="text-center"><?= $user['email'] ?></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="h5 text-center">дата регистрации</p>
                </td>
                <td>
                    <p class="text-center"><?= $user['date_create'] ?></p>
                </td>
            </tr>
        </table>
    </div>

    <div class="float-right px-5">
        <form action="/auth" method="post">
            <input class="btn btn-dark" type="submit" name="logout" value="Выйти с сайта">
        </form>
    </div>


<?php
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'footer.php');
