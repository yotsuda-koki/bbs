<?php

require_once('../../App/config.php');

use App\Util\Common;
use App\Model\Base;
use App\Model\Users;

$post = Common::sanitize($_POST);

if (!isset($post['token']) || !Common::isValidToken($post['token'])) {
    $_SESSION['msg']['error'] = '不正なアクセスです';
    header('Location: ./register.php');
    exit();
}

$data = array(
    'name' => $post['name'],
    'pass' => $post['pass'],
    'email' => $post['email'],
    'id' => $post['id']
);

try {
    $base = Base::getInstance();
    $db = new Users($base);
    if ($db->updateUser($data)) {
        header('Location: ' . TOP_URL);
        exit();
    } else {
        header('Location: ' . ERROR_URL);
        exit();
    }
} catch (Exception $e) {
    header('Location: ' . ERROR_URL);
    exit();
}
