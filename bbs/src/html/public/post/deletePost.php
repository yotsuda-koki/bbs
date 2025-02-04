<?php
// コンフィグファイルの読み込み
require_once('../../App/config.php');
// クラスの読み込み
use App\Util\Common;
use App\Model\Base;
use App\Model\Posts;

if (empty($_SESSION['user'])) {
    // 未ログイン
    header('Location: ../login/');
} else {
    // ログイン済み
    $user = $_SESSION['user'];
}
// サニタイズ
$post = Common::sanitize($_POST);

try {
    // ポスト情報の取得
    $base = Base::getInstance();
    $db = new Posts($base);
    $p = $db->getPostByID($post['id']);
    // ログインユーザーがアドミンでないかつポストの所有者がログインユーザーでない場合、エラーページへリダイレクト
    if ($user['is_admin'] == 0 && $p['user_id'] !== $user['id']) {
        header('Location: ' . ERROR_URL);
        exit();
    }
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
    <title>ポスト削除</title>
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
                    <div class="alert alert-danger text-center" role="alert">
                        <?= $_SESSION['msg']['error'] ?>
                    </div>
                <?php endif ?>
                <?php unset($_SESSION['msg']) ?>
                <div class="alert alert-primary text-center" role="alert">
                    こちらのポストを削除します。
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="./deletePost_action.php" method="post">
                            <input type="hidden" name="token" value="<?= $token ?>">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="title" class="form-label">タイトル</label>
                                </div>
                                <div class="col-sm-8">
                                    <p type="text" class="form-control" id="title"><?= $p['title'] ?></p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <label for="content" class="form-label">内容</label>
                                </div>
                                <div class="col-sm-8">
                                    <p class="form-control" id="content"><?= $p['content'] ?></p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <input type="submit" class="btn btn-danger me-2" value="削除">
                                <a href="../top/" class="btn btn-outline-primary">キャンセル</a>
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