<?php

require_once('../../App/config.php');

use App\Util\Common;
use App\Model\Base;
use App\Model\Users;

$post = Common::sanitize($_POST);

if (!isset($post['token']) || !Common::isValidToken($post['token'])) {
    $_SESSION['msg']['error'] = '不正なアクセスです';
    header('Location: ./login');
    exit();
}

try {
    $base = Base::getInstance();
    $db = new Users($base);
    $user = $db->signInUser($post['pass'], $post['email']);

    if (!empty($user)) {

        $_SESSION['user'] = $user;

        unset($_SESSION['msg']['error']);

        $_SESSION['msg']['success'] = 'ログインしました。';

        header('Location: ' . TOP_URL);
        exit();
    } else {
        $_SESSION['msg']['failure'] = 'ログインに失敗しました。';

        header('Location: ' . TOP_URL);
        exit();
    }
} catch (Exception $e) {
    // var_dump($e->getMessage());
    // exit;
    header('Location: ' . ERROR_URL);
    exit();
}
