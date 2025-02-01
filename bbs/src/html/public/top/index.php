<?php
//コンフィグファイルを読み込む
require_once('../../App/config.php');
//クラスを読み込む
use App\Util\Common;
use App\Model\Base;
use App\Model\Posts;

$get = Common::sanitize($_GET);
//セッションに保存されているエラーメッセージを削除
unset($_SESSION['msg']['error']);

if (!empty($_SESSION['user'])) {
    //ログイン時
    $user = $_SESSION['user'];
}


if (isset($get['cancell']) && $get['cancell'] == 1) {
    unset($_SESSION['msg']['success']);
    unset($_SESSION['msg']['failure']);
}

try {
    $base = Base::getInstance();
    $db = new Posts($base);
    $posts = $db->viewAllPosts();
} catch (Exception $e) {
    // $e->getMessage();
    // var_dump($e);
    // exit();
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
    <title>掲示板フォーラム</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <!-- ナビゲーション -->
    <nav class="navbar navbar-expand-sm navbar-light bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand">掲示板フォーラム</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarID" aria-controls="navbarID" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarID">
                <div class="navbar-nav">
                    <a class="nav-link"><?= isset($user) ? $user['account_id'] : 'AccoutId' ?></a>
                    <a class="nav-link"><?= isset($user) ? $user['name'] : 'UserName' ?></a>
                    <a class="nav-link" aria-current="page" href="../post/post.php">Post</a>
                </div>
            </div>
            <div class="row mx-1">
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
            <?php if (isset($user)) : ?>
                <div class="row mx-1">
                    <a href="../login/logout.php" class="btn btn-outline-danger">Logout</a>
                </div>
            <?php else : ?>
                <div class="row mx-1">
                    <a href="../login/" class="btn btn-outline-primary">Login</a>
                </div>
                <div class="row mx-1">
                    <a href="../user/register.php" class="btn btn-outline-primary">SignUp</a>
                </div>
            <?php endif ?>
        </div>
    </nav>
    <!-- ナビゲーション -->
    <!-- コンテナ -->
    <div class="container">
        <div class="row my-3">
            <?php if (isset($_SESSION['msg']['success'])) : ?>
                <div class="col-3"></div>
                <div class="col-6">
                    <div class="alert alert-primary" role="alert">
                        <?= $_SESSION['msg']['success'] ?>
                    </div>
                </div>
                <div class="col-3"></div>
            <?php elseif (isset($_SESSION['msg']['failure'])) : ?>
                <div class="col-3"></div>
                <div class="col-6">
                    <div class="alert alert-danger text-center" role="alert">
                        <?= $_SESSION['msg']['failure'] ?>
                    </div>
                </div>
                <div class="col-3"></div>
            <?php endif ?>
            <div class="d-flex justify-content-center">
                <h2>掲示板一覧</h2>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">タイトル</th>
                        <th scope="col">作成者</th>
                        <th scope="col">作成日時</th>
                        <th scope="col">更新日時</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post) : ?>
                        <tr>
                            <th scope="row"><?= $post['id'] ?></th>
                            <td><a href="../post/viewPost.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a></td>
                            <td><?= $post['name'] ?></td>
                            <td><?= $post['create_at'] ?></td>
                            <td><?= $post['update_at'] ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- コンテナ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>