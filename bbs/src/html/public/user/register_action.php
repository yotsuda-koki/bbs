<?php

require_once('../../App/config.php');

use App\Util\Common;
use App\Util\Validation;
use App\Model\Base;
use App\Model\Users;

$post = Common::sanitize($_POST);

$_SESSION['signUp'] = $post;

if (!isset($post['token']) || !Common::isValidToken($post['token'])) {
    $_SESSION['msg']['error'] = '不正なアクセスです';
    header('Location: ./register.php');
    exit();
}

if (!Validation::isValidUserAccountID($post['account_id'])) {
    header('Location: ./register.php');
    exit();
}

if (!Validation::isValidUserName($post['name'])) {
    header('Location: ./register.php');
    exit();
}

if (!Validation::isValidUserPass($post['pass'])) {
    header('Location: ./register.php');
    exit();
}

if (!Validation::isValidUserEmail($post['email'])) {
    header('Location: ./register.php');
    exit();
}

$data = array(
    'account_id' => $post['account_id'],
    'name' => $post['name'],
    'pass' => $post['pass'],
    'email' => $post['email']
);

try {
    $base = Base::getInstance();
    $db = new Users($base);
    $db->signUpUser($data);
    unset($_SESSION['signUp']);
    header('Location: ' . TOP_URL);
    exit();
} catch (Exception $e) {
    header('Location: ' . ERROR_URL);
    exit();
}
