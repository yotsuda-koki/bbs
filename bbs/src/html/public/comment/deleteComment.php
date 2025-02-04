<?php
// コンフィグファイルの読み込み
require_once('../../App/config.php');
// クラスの読み込み
use App\Util\Common;
use App\Model\Base;
use App\Model\Comments;

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
    $db = new Comments($base);
    $c = $db->viewCommentsByID($post['id']);
    // ログインユーザーがアドミンでないかつポストの所有者がログインユーザーでない場合、エラーページへリダイレクト
    if ($user['is_admin'] == 0 && $c['user_id'] !== $user['id']) {
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
    <title>コメント削除</title>
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
                <?php unset($_SESSION['msg']) ?>
                <div class="card my-5">
                    <div class="card-header">
                        コメント削除
                    </div>
                    <div class="card-body">
                        <form action="./deleteComment_action.php" method="post">
                            <input type="hidden" name="token" value="<?= $token ?>">
                            <input type="hidden" name="id" value="<?= $c['id'] ?>">
                            <div class="mb-3">
                                <label for="content" class="form-label">コメント内容</label>
                                <p class="form-control" id="content" name="content" rows="5"><?= $c['content'] ?></p>
                            </div>
                            <input type="submit" class="btn btn-danger" value="削除">
                            <a href="../top/" class="btn btn-outline-primary">キャンセル</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>