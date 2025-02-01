<?php

namespace App\Model;

class Users
{
    /**
     * プライベート変数
     *
     * @var \PDO
     */
    private $pdo;
    /**
     * コンストラクタ
     *
     * @param \PDO $pdo PDOクラスインスタンス
     */
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    /**
     * メールアドレスとパスワードから検索してユーザー情報を取得する
     *
     * @param string $pass パスワード
     * @param string $email メールアドレス
     * @return array ユーザー情報
     */
    public function signInUser($pass, $email)
    {
        //$emailが空なら空の配列を返却する
        if (empty($email)) {
            return [];
        }

        $sql = '';
        $sql .= 'select ';
        $sql .= 'id, ';
        $sql .= 'account_id, ';
        $sql .= 'name, ';
        $sql .= 'pass, ';
        $sql .= 'email, ';
        $sql .= 'is_admin ';
        $sql .= 'from ';
        $sql .= 'users ';
        $sql .= 'where ';
        $sql .= 'is_deleted = 0 ';
        $sql .= 'and email = :email';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();

        $rec = $stmt->fetch();
        //取得できなかったときは空の配列を返却する
        if (!$rec) {
            return [];
        }
        //パスワードがハッシュにマッチするかどうかを調べる
        if (!password_verify($pass, $rec['pass'])) {
            return [];
        }
        //セキュリティ対策としてパスワードの情報を削除する
        unset($rec['pass']);

        return $rec;
    }
    /**
     * ユーザーを登録する
     *
     * @param array $date
     * @return bool
     */
    public function signUpUser($data)
    {
        //データが空でないか確認
        if (empty($data)) {
            return false;
        }
        //パスワードをハッシュ化する
        $pass = password_hash($data['pass'], PASSWORD_DEFAULT);

        $sql = '';
        $sql .= 'insert into users (';
        $sql .= 'account_id, ';
        $sql .= 'name, ';
        $sql .= 'pass, ';
        $sql .= 'email, ';
        $sql .= 'is_admin';
        $sql .= ') VALUES (';
        $sql .= ':account_id,';
        $sql .= ':name,';
        $sql .= ':pass,';
        $sql .= ':email,';
        $sql .= ':is_admin';
        $sql .= ')';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':account_id', $data['account_id'], \PDO::PARAM_STR);
        $stmt->bindParam(':name', $data['name'], \PDO::PARAM_STR);
        $stmt->bindParam(':pass', $pass, \PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], \PDO::PARAM_STR);
        $stmt->bindParam(':is_admin', $data['is_admin'], \PDO::PARAM_INT);
        $ret = $stmt->execute();

        return $ret;
    }

    public function updateUser($data)
    {

        if (!isset($data)) {
            return false;
        }

        $pass = password_hash($data['pass'], PASSWORD_BCRYPT);

        $sql = '';
        $sql .= 'update users set ';
        $sql .= 'name = :name,';
        $sql .= 'pass = :pass,';
        $sql .= 'email = :email ';
        $sql .= 'where id = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':name', $data['name'], \PDO::PARAM_STR);
        $stmt->bindParam(':pass', $pass, \PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], \PDO::PARAM_STR);
        $stmt->bindParam(':id', $data['id'], \PDO::PARAM_INT);
        $ret = $stmt->execute();

        return $ret;
    }
}
