<?php

require_once('../../App/config.php');

use App\Util\Common;

unset($_SESSION['msg']['success']);
unset($_SESSION['msg']['failure']);

$token = Common::generateToken();
?>
<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <?php if (isset($_SESSION['msg']['error'])) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $_SESSION['msg']['error'] ?>
                    </div>
                <?php endif ?>
                <div class="alert alert-primary" role="alert">
                    ユーザーを登録してください。
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="./register_action.php" method="post">
                            <input type="hidden" name="token" value="<?= $token ?>">
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="account_id" class="form-label">アカウントID</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="account_id" name="account_id">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="name" class="form-label">ユーザー名</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="name" name="name">
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
                                    <input type="text" class="form-control" id="email" name="email">
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <input type="submit" class="btn btn-primary me-2" value="登録">
                                <a href="../top/index.php?cancell=1" class="btn btn-outline-primary">キャンセル</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>