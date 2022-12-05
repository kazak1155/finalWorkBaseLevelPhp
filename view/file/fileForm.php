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

<h2>page of upload FILE</h2>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <form action="/file" method="post" enctype="multipart/form-data">
                <label for="formFileLg" class="form-label">указать файл загрузки</label>
                <input class="form-control form-control-lg" id="formFileLg" type="file" />
                <br>
                <input type="submit" value="Отправить"></p>
            </form>
        </div>
    </div>

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . 'footer.php');
