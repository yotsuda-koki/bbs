<?php

require_once('../../App/config.php');

use App\Util\Common;
use App\Util\Validation;
use App\Model\Base;
use App\Model\Users;

$post = Common::sanitize($_POST);


if (!isset($post['token']) || !Common::isValidToken($post['token'])) {
    $_SESSION['msg']['error'] = '不正なアクセスです';
    header('Location: ./editUser.php');
    exit();
}

if (!Validation::isValidEditUserAccountID($post['account_id'], $post['id'])) {
    header('Location: ./editUser.php');
    exit();
}


if (!Validation::isValidEditUserName($post['name'], $post['id'])) {
    header('Location: ./editUser.php');
    exit();
}

if (!Validation::isValidUserPass($post['pass'])) {
    header('Location: ./editUser.php');
    exit();
}

if (!Validation::isValidEditUserEmail($post['email'], $post['id'])) {
    header('Location: ./editUser.php');
    exit();
}

$data = array(
    'account_id' => $post['account_id'],
    'name' => $post['name'],
    'pass' => $post['pass'],
    'email' => $post['email'],
    'id' => $post['id']
);

try {
    $base = Base::getInstance();
    $db = new Users($base);
    $db->updateUser($data);
    unset($_SESSION['edit']);
    header('Location: ' . TOP_URL);
    exit();
} catch (Exception $e) {
    header('Location: ' . ERROR_URL);
    exit();
}
