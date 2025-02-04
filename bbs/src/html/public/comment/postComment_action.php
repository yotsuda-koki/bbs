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
    header('Location: ../top/');
    exit();
}

$data = array(
    'user_id' => $post['user_id'],
    'post_id' => $post['post_id'],
    'content' => $post['content'],
);

try {
    //ポストを修正
    $base = Base::getInstance();
    $db = new Comments($base);
    $db->uploadComment($data);
    //サクセスメッセージを保存してTOPページへ
    $_SESSION['msg']['success'] = 'コメントを投稿しました。';
    header('Location: ../top/');
    exit();
} catch (Exception $e) {
    //エラー時エラーページへ
    header('Location: ' . ERROR_URL);
    exit();
}
