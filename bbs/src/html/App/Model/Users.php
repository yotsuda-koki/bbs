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
     * アドミンでないし削除されていないユーザーをすべて取得
     *
     * @return array
     */
    public function getUsersAll()
    {

        $sql = '';
        $sql .= 'select ';
        $sql .= 'id, ';
        $sql .= 'account_id ';
        $sql .= 'from ';
        $sql .= 'users ';
        $sql .= 'where ';
        $sql .= 'is_admin = 0 ';
        $sql .= 'and is_deleted = 0 ';
        $sql .= 'order by id asc ';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $rec = $stmt->fetchAll();

        return $rec;
    }
    /**
     * アドミンでないし削除されていないユーザーをすべて取得
     *
     * @return array
     */
    public function getUserById($id)
    {
        if (!is_numeric($id)) {
            return [];
        }

        if ($id <= 0) {
            return [];
        }

        $sql = '';
        $sql .= 'select ';
        $sql .= 'id, ';
        $sql .= 'account_id, ';
        $sql .= 'name, ';
        $sql .= 'email ';
        $sql .= 'from ';
        $sql .= 'users ';
        $sql .= 'where ';
        $sql .= 'id = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        $rec = $stmt->fetch();

        return $rec;
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
        $sql .= 'insert into users ( ';
        $sql .= 'account_id, ';
        $sql .= 'name, ';
        $sql .= 'pass, ';
        $sql .= 'email ';
        $sql .= ') values ( ';
        $sql .= ':account_id, ';
        $sql .= ':name, ';
        $sql .= ':pass, ';
        $sql .= ':email ';
        $sql .= ')';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':account_id', $data['account_id'], \PDO::PARAM_STR);
        $stmt->bindParam(':name', $data['name'], \PDO::PARAM_STR);
        $stmt->bindParam(':pass', $pass, \PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], \PDO::PARAM_STR);
        $ret = $stmt->execute();

        return $ret;
    }
    /**
     * ユーザー情報を変更する
     *
     * @param array $data
     * @return bool
     */
    public function updateUser($data)
    {

        if (!isset($data)) {
            return false;
        }

        $pass = password_hash($data['pass'], PASSWORD_DEFAULT);

        $sql = '';
        $sql .= 'update users set ';
        $sql .= 'account_id = :account_id,';
        $sql .= 'name = :name,';
        $sql .= 'pass = :pass,';
        $sql .= 'email = :email ';
        $sql .= 'where id = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':account_id', $data['account_id'], \PDO::PARAM_STR);
        $stmt->bindParam(':name', $data['name'], \PDO::PARAM_STR);
        $stmt->bindParam(':pass', $pass, \PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], \PDO::PARAM_STR);
        $stmt->bindParam(':id', $data['id'], \PDO::PARAM_INT);
        $ret = $stmt->execute();

        return $ret;
    }
    /**
     * 指定IDのユーザーを削除する
     *
     * @param int $id
     * @return bool
     */
    public function deleteUser($id)
    {
        if (!is_numeric($id)) {
            return false;
        }

        if ($id <= 0) {
            return false;
        }

        $sql = '';
        $sql .= 'update users set ';
        $sql .= 'is_deleted = 1 ';
        $sql .= 'where id = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $ret = $stmt->execute();

        return $ret;
    }
    /**
     * アカウントIDのバリデーションチェック
     *
     * @param string $accountId
     * @return bool
     */
    public function isValidEditAccountId($accountId, $id)
    {

        $sql = '';
        $sql .= 'select ';
        $sql .= 'count(*) ';
        $sql .= 'from ';
        $sql .= 'users ';
        $sql .= 'where ';
        $sql .= 'account_id = :account_id ';
        $sql .= 'and ';
        $sql .= 'id != :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':account_id', $accountId, \PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * 名前のバリデーションチェック
     *
     * @param string $name
     * @return bool
     */
    public function isValidEditName($name, $id)
    {

        $sql = '';
        $sql .= 'select ';
        $sql .= 'count(*) ';
        $sql .= 'from ';
        $sql .= 'users ';
        $sql .= 'where ';
        $sql .= 'name = :name ';
        $sql .= 'and ';
        $sql .= 'id != :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * メールアドレスのバリデーションチェック
     *
     * @param string $email
     * @return bool
     */
    public function isValidEditEmail($email, $id)
    {

        $sql = '';
        $sql .= 'select ';
        $sql .= 'count(*) ';
        $sql .= 'from ';
        $sql .= 'users ';
        $sql .= 'where ';
        $sql .= 'email = :email ';
        $sql .= 'and ';
        $sql .= 'id != :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * アカウントIDのバリデーションチェック
     *
     * @param string $accountId
     * @return bool
     */
    public function isValidAccountId($accountId)
    {

        $sql = '';
        $sql .= 'select ';
        $sql .= 'count(*) ';
        $sql .= 'from ';
        $sql .= 'users ';
        $sql .= 'where ';
        $sql .= 'account_id = :account_id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':account_id', $accountId, \PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * 名前のバリデーションチェック
     *
     * @param string $name
     * @return bool
     */
    public function isValidName($name)
    {

        $sql = '';
        $sql .= 'select ';
        $sql .= 'count(*) ';
        $sql .= 'from ';
        $sql .= 'users ';
        $sql .= 'where ';
        $sql .= 'name = :name';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * メールアドレスのバリデーションチェック
     *
     * @param string $email
     * @return bool
     */
    public function isValidEmail($email)
    {

        $sql = '';
        $sql .= 'select ';
        $sql .= 'count(*) ';
        $sql .= 'from ';
        $sql .= 'users ';
        $sql .= 'where ';
        $sql .= 'email = :email';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * アカウントIDを検索する
     *
     * @param string $accountId
     * @return array
     */
    public function searchUser($accountId)
    {

        $sql = '';
        $sql .= 'select ';
        $sql .= 'id, ';
        $sql .= 'account_id, ';
        $sql .= 'name ';
        $sql .= 'from ';
        $sql .= 'users ';
        $sql .= 'where ';
        $sql .= 'is_admin = 0 ';
        $sql .= 'and ';
        $sql .= 'is_deleted = 0 ';
        $sql .= 'and ';
        $sql .= 'account_id ';
        $sql .= 'like ';
        $sql .= ':account_id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':account_id', '%' . $accountId . '%', \PDO::PARAM_STR);
        $stmt->execute();
        $rec = $stmt->fetchAll();

        return $rec;
    }
}
