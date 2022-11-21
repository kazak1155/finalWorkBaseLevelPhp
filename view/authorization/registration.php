<?php
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'header.php');

if (!empty($_SESSION['error']) && !empty($_SESSION['error'])) { ?>
    <div class="alert alert-danger"><?= $_SESSION['error'] ?>
    </div><?php } $_SESSION['error'] = '';?>
<?php if (isset($_SESSION['success']) && !empty($_SESSION['success'])) { ?>
    <div class="alert alert-info"><?= $_SESSION['success'] ?>
    </div><?php } $_SESSION['success'] = '';?>
    <h2>Регистрация нового пользователя</h2>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <form action="/registration" method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">введите имя</label>
                    <input required name="name" type="text" class="form-control" id="name" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">введите фамилию</label>
                    <input required name="surname" type="text" class="form-control" id="surname" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">введите email</label>
                    <input required name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">ведите пароль</label>
                    <input required name="password" type="password" class="form-control" id="password">
                </div>
                <br>
                <input name="send" type="submit" class="btn btn-primary" value="зарегистрироваться">
            </form>
        </div>
    </div>

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'footer.php');
