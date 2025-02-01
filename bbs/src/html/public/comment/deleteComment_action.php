<?php
//コンフィグファイルの読み込み
require_once('../../App/config.php');
//クラスの読み込み
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
//サニタイズ
$post = Common::sanitize($_POST);
//ワンタイムトークンのチェック
if (!isset($post['token']) || !Common::isValidToken($post['token'])) {
    $_SESSION['msg']['error'] = '不正なアクセスです';
    header('Location: ./post.php');
    exit();
}

try {
    //ポストを修正
    $base = Base::getInstance();
    $db = new Comments($base);
    $db->deletePost($post['id']);
    //エラーメッセージを削除
    unset($_SESSION['msg']['error']);
    //サクセスメッセージを保存してTOPページへ
    $_SESSION['msg']['success'] = 'コメントを削除しました。';
    header('Location: ' . TOP_URL);
    exit();
} catch (Exception $e) {
    //エラー時エラーページへ
    header('Location: ' . ERROR_URL);
    exit();
}
