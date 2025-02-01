<?php
//コンフィグファイルを読み込み
require_once('../../App/config.php');
//クラスを読み込み
use App\Util\Common;
//セッションに保存されているエラーメッセージを削除
unset($_SESSION['msg']['error']);

if (empty($_SESSION['user'])) {
    // 未ログイン
    header('Location: ' . LOGIN_URL);
} else {
    // ログイン済み
    $user = $_SESSION['user'];
}
//ワンタイムトークンの作成
$token = Common::generateToken();
?>
<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ポスト投稿</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        textarea {
            resize: none;
            height: 300px;
        }
    </style>
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
                    ポストを投稿してください。
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="./post_action.php" method="post">
                            <input type="hidden" name="token" value="<?= $token ?>">
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="title" class="form-label">タイトル</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="title" name="title">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="content" class="form-label">内容</label>
                                </div>
                                <div class="col-sm-8">
                                    <textarea class="form-control" name="content" id="content"></textarea>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <input type="submit" class="btn btn-primary me-2" value="投稿">
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