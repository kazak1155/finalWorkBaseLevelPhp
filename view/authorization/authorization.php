<?php
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'header.php');

if (!empty($_SESSION['error']) && !empty($_SESSION['error'])) { ?>
    <div class="alert alert-danger"><?= $_SESSION['error'] ?>
    </div><?php } $_SESSION['error'] = '';?>
<?php if (isset($_SESSION['success']) && !empty($_SESSION['success'])) { ?>
    <div class="alert alert-info"><?= $_SESSION['success'] ?>
    </div><?php } $_SESSION['success'] = '';?>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <form action="/login" method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">введите email</label>
                    <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">ведите пароль</label>
                    <input name="password" type="password" class="form-control" id="password">
                </div>
                <br>
                <button name="send" type="submit" class="btn btn-primary">авторизироваться</button>
            </form>
        </div>
    </div>

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'footer.php');
