<?php

/**
 * データベース接続文字列
 */
define('DSN', 'mysql:dbname=bbs;host=localhost;charset=utf8mb4');
/**
 * データベース接続ユーザー名
 */
define('DB_USER', 'root');
/**
 * データベース接続パスワード
 */
define('DB_PASS', '');
/**
 * ErrorページのURL
 */
define('ERROR_URL', '../error/error.php');
/**
 * TOPページのURL
 */
define('TOP_URL', '../top/index.php');
/**
 * LOGINページのURL
 */
define('LOGIN_URL', '../login/index.php');
/**
 * セッション自動スタート
 */
session_start();
session_regenerate_id();
/**
 * クラスを自動で読み込む
 */
spl_autoload_register(function ($class) {

    $file = sprintf(__DIR__ . '/%s.php', $class);

    $file = str_replace('App/App', 'App', $file);

    $file = str_replace('\\', '/', $file);

    if (file_exists($file)) {
        require($file);
    } else {
        echo 'File not found' . $file;
        exit;
    }
});
