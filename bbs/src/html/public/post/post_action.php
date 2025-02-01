<?php
//コンフィグファイルの読み込み
require_once('../../App/config.php');
//クラスの読み込み
use App\Util\Common;
use App\Model\Base;
use App\Model\Posts;

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
//データ配列
$data = array(
    'user_id' => $user['id'],
    'title' => $post['title'],
    'content' => $post['content'],
);

try {
    //データベースにポストをインサートする
    $base = Base::getInstance();
    $db = new Posts($base);
    $db->uploadPost($data);
    //エラーメッセージを削除
    unset($_SESSION['msg']['error']);
    //サクセスメッセージを保存してTOPページへ
    $_SESSION['msg']['success'] = 'ポストを投稿しました。';
    header('Location: ' . TOP_URL);
    exit();
} catch (Exception $e) {
    //エラー時エラーページへ
    header('Location: ' . ERROR_URL);
    exit();
}
