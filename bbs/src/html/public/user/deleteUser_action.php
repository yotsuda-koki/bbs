<?php

require_once('../../App/config.php');

use App\Util\Common;
use App\Model\Base;
use App\Model\Users;

$post = Common::sanitize($_POST);

if (!isset($post['token']) || !Common::isValidToken($post['token'])) {
    $_SESSION['msg']['error'] = '不正なアクセスです';
    header('Location: ./deleteUser.php');
    exit();
}

try {
    $base = Base::getInstance();
    $db = new Users($base);
    $db->deleteUser($post['user_id']);
    header('Location: ' . TOP_URL);
    exit();
} catch (Exception $e) {
    header('Location: ' . ERROR_URL);
    exit();
}
