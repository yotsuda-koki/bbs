<?php

require_once('../../App/config.php');

unset($_SESSION['user']);
unset($_SESSION['msg']);

$_SESSION['msg']['success'] = 'ログアウトしました。';

header('Location: ' . TOP_URL);
exit();
