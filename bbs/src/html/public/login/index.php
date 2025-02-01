<?php

require_once('../../App/config.php');

use App\Util\Common;

$token = Common::generateToken();

?>
<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <?php if (isset($_SESSION['msg']['error'])) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $_SESSION['msg']['error'] ?>
                    </div>
                <?php endif ?>
                <div class="alert alert-primary" role="alert">
                    ログインしてください。
                </div>
                <div class="card">
                    <div class="card-header">
                        ログインフォーム
                    </div>
                    <div class="card-body">
                        <form action="./login.php" method="post">
                            <input type="hidden" name="token" value="<?= $token ?>">
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="email" class="form-label">メールアドレス</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="email" name="email">
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
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-2">ログイン</button>
                                <a href="../top/index.php?cancell=1" class="btn btn-outline-primary">キャンセル</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>