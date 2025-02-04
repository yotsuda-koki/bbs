<?php
//コンフィグファイルを読み込み
require_once('../../App/config.php');
//クラスを読み込み
use App\Util\Common;
use App\Model\Base;
use App\Model\Posts;
use App\Model\Comments;

$post = Common::sanitize($_POST);
//セッションに保存されているエラーメッセージを削除
unset($_SESSION['msg']['error']);

if (empty($_SESSION['user'])) {
    // 未ログイン
    $_SESSION['msg']['failure'] = 'ログインしてください。';
    header('Location: ' . TOP_URL);
    exit();
} else {
    // ログイン済み
    $user = $_SESSION['user'];
}

try {
    //ポスト情報の取得
    $base = Base::getInstance();
    $db = new Posts($base);
    $p = $db->getPostByID($post['id']);
    //コメント情報の取得
    $db = new Comments($base);
    $comments = $db->getCommentsByPostID($post['id']);
} catch (Exception $e) {
    //エラー時エラーページへ
    header('Location: ' . ERROR_URL);
    exit;
}
//ワンタイムトークンの作成
$token = Common::generateToken();
?>
<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ポスト</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        textarea {
            resize: none;
        }

        .half-width {
            width: 50%;
        }

        .line {
            border-top: 1px solid #ccc;
            margin-top: 15px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card mt-5 mb-2">
            <div class="card-body">
                <div class="row">
                    <div>
                        <h5 class="card-title"><?= $p['name'] ?></h5>
                    </div>
                    <div>
                        <h4 class="card-title me-2"><?= $p['title'] ?></h4>
                    </div>
                </div>
                <h6 class="card-subtitle text-body-secondary my-1">作成日時:<?= $p['create_at'] ?> 更新日時:<?= $p['update_at'] ?></h6>
                <p class="card-text"><?= $p['content'] ?></p>
                <div class="d-flex justify-content-end">
                    <?php if ($user['is_admin'] == 1 || $user['id'] === $p['user_id']) : ?>
                        <form action="../post/editPost.php" method="post">
                            <input type="hidden" name="token" value="<?= $token ?>">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <input type="submit" class="btn btn-outline-success me-1 mb-1" value="編集">
                        </form>
                        <form action="../post/deletePost.php" method="post">
                            <input type="hidden" name="token" value="<?= $token ?>">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <input type="submit" class="btn btn-outline-danger me-1 mb-1" value="削除">
                        </form>
                    <?php endif ?>
                    <a href="../top/" class="btn btn-outline-primary  me-1 mb-1">戻る</a>
                </div>
            </div>
        </div>
        <div class="line"></div>
        <div class="half-width">
            <form action="../comment/postComment_action.php" method="post">
                <input type="hidden" name="token" value="<?= $token ?>">
                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                <input type="hidden" name="post_id" value="<?= $p['id'] ?>">
                <div class="row">
                    <div class="col-md-9">
                        <textarea class="form-control" name="content"></textarea>
                    </div>
                    <div class="col-md-3  d-flex align-items-end">
                        <input type="submit" class="btn btn-outline-primary" value="コメントする">
                    </div>
                </div>
            </form>
        </div>
        <div class="line"></div>
        <div class="half-width">
            <h6>コメント一覧</h6>
            <?php foreach ($comments as $c) : ?>
                <div class="card mb-1">
                    <div class="card-header">
                        名前:<?= $c['name'] ?>
                    </div>
                    <div class="card-body">
                        <?= $c['content'] ?>
                    </div>
                    <?php if ($user['is_admin'] == 1 || $user['id'] === $c['user_id']) : ?>
                        <div class="d-flex justify-content-end">
                            <form action="../comment/editComment.php" method="post">
                                <input type="hidden" name="token" value="<?= $token ?>">
                                <input type="hidden" name="id" value="<?= $c['id'] ?>">
                                <input type="submit" class="btn btn-outline-success me-1 mb-1" value="編集">
                            </form>
                            <form action="../comment/deleteComment.php" method="post">
                                <input type="hidden" name="token" value="<?= $token ?>">
                                <input type="hidden" name="id" value="<?= $c['id'] ?>">
                                <input type="submit" class="btn btn-outline-danger me-1 mb-1" value="削除">
                            </form>
                        </div>
                    <?php endif ?>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>