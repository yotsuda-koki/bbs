<?php

require_once('../../App/config.php');

use App\Util\Common;
use App\Model\Base;
use App\Model\Users;

if (empty($_SESSION['user'])) {
    // 未ログインのとき
    header('Location: ' . TOP_URL);
} else {
    // ログイン済みのとき
    $user = $_SESSION['user'];
}

$post = Common::sanitize($_POST);

if (isset($post['user_id'])) {
    $_SESSION['edit'] = $post['user_id'];
}

try {
    $base = Base::getInstance();
    $db = new Users($base);
    $u = $db->getUserById($_SESSION['edit']);
} catch (Exception $e) {
    header('Location: ' . ERROR_URL);
    exit();
}

$token = Common::generateToken();

?>
<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザーの変更</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <?php if (isset($_SESSION['msg']['error'])) : ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <?= $_SESSION['msg']['error'] ?>
                    </div>
                <?php endif ?>
                <?php unset($_SESSION['msg']) ?>
                <div class="alert alert-primary text-center" role="alert">
                    ユーザー情報を変更してください。
                </div>
                <div class="card my-3">
                    <div class="card-body">
                        <form action="./editUser_action.php" method="post">
                            <input type="hidden" name="token" value="<?= $token ?>">
                            <input type="hidden" name="id" value="<?= $u['id'] ?>">
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="account_id" class="form-label">アカウントID</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="account_id" name="account_id" value="<?= $u['account_id'] ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="name" class="form-label">ユーザー名</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="name" name="name" value="<?= $u['name'] ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="pass" class="form-label">パスワード</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" id="pass" name="pass">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="email" class="form-label">メールアドレス</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="email" name="email" value="<?= $u['email'] ?>">
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success me-2">変更</button>
                                <a href="../top/index.php" class="btn btn-outline-primary">キャンセル</a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>