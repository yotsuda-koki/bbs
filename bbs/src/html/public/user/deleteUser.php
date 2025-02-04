<?php

require_once('../../App/config.php');

use App\Util\Common;
use App\Model\Base;
use App\Model\Users;

$post = Common::sanitize($_POST);

if (empty($_SESSION['user'])) {
    // 未ログインのとき
    header('Location: ' . TOP_URL);
} else {
    // ログイン済みのとき
    $user = $_SESSION['user'];
}

try {
    $base = Base::getInstance();
    $db = new Users($base);
    $users = $db->searchUser($post['account_id']);
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
    <title>ユーザーの削除</title>
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
                    削除するユーザーを選択してください
                </div>
                <div class="card my-3">
                    <div class="card-header text-center">
                        削除するユーザーを検索してください
                    </div>
                    <div class="card-body">
                        <form action="./deleteUser_action.php" method="post">
                            <input type="hidden" name="token" value="<?= $token ?>">
                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="account_id" class="form-label">アカウントID</label>
                                </div>
                                <div class="col-sm-6">
                                    <select name="user_id" class="form-select">
                                        <option selected>削除するユーザーを選択してください</option>
                                        <?php foreach ($users as $u) : ?>
                                            <option value="<?= $u['id'] ?>"><?= $u['account_id'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <input type="submit" class="btn btn-danger me-2" value="削除">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="../top/index.php" class="btn btn-outline-primary">戻る</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>