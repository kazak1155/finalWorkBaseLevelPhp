<?php
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'header.php');

if (!empty($_SESSION['error']) && !empty($_SESSION['error'])) { ?>
    <div class="alert alert-danger"><?= $_SESSION['error'] ?>
    </div><?php } $_SESSION['error'] = '';?>
<?php if (isset($_SESSION['success']) && !empty($_SESSION['success'])) { ?>
    <div class="alert alert-info"><?= $_SESSION['success'] ?>
    </div><?php } $_SESSION['success'] = '';?>
    <h2>passwordReset</h2>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <form action="/login" method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">введите email</label>
                    <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp">
                </div>
                <br>
                <button name="passwordReset" type="submit" class="btn btn-primary">сбросить пароль</button>
            </form>
        </div>
    </div>

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'footer.php');
