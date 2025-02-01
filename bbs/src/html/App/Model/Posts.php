<?php

namespace App\Model;

class Posts
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
     * @param \PDO $pdo
     */
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    /**
     * すべてのポストを閲覧する
     *
     * @return array
     */
    public function viewAllPosts()
    {

        $sql = '';
        $sql .= 'select ';
        $sql .= 'p.id, ';
        $sql .= 'p.user_id, ';
        $sql .= 'u.name, ';
        $sql .= 'p.title, ';
        $sql .= 'p.create_at, ';
        $sql .= 'p.update_at ';
        $sql .= 'from posts p ';
        $sql .= 'inner join users u on p.user_id = u.id ';
        $sql .= 'where p.is_deleted = 0 ';
        $sql .= 'order by update_at';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $ret = $stmt->fetchAll();

        return $ret;
    }
    /**
     * 指定IDからポストを取得する
     *
     * @param int $id
     * @return array
     */
    public function viewPostByID($id)
    {

        $sql = '';
        $sql .= 'select ';
        $sql .= 'p.id, ';
        $sql .= 'p.user_id, ';
        $sql .= 'u.name, ';
        $sql .= 'p.title, ';
        $sql .= 'p.content, ';
        $sql .= 'p.create_at, ';
        $sql .= 'p.update_at ';
        $sql .= 'from posts p ';
        $sql .= 'inner join users u on p.user_id = u.id ';
        $sql .= 'where p.is_deleted = 0 ';
        $sql .= 'and p.id = :id ';
        $sql .= 'order by update_at';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $ret = $stmt->fetch();

        return $ret;
    }
    /**
     * ポストを投稿する
     *
     * @param array $data
     * @return bool
     */
    public function uploadPost($data)
    {

        if (!isset($data)) {
            return false;
        }

        $sql = '';
        $sql .= 'insert into posts (';
        $sql .= 'user_id,';
        $sql .= 'title,';
        $sql .= 'content';
        $sql .= ') values (';
        $sql .= ':user_id,';
        $sql .= ':title,';
        $sql .= ':content';
        $sql .= ')';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $data['user_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':title', $data['title'], \PDO::PARAM_STR);
        $stmt->bindParam(':content', $data['content'], \PDO::PARAM_STR);
        $ret = $stmt->execute();

        return $ret;
    }
    /**
     * ポストを編集する
     *
     * @param array $data
     * @return bool
     */
    public function updatePost($data)
    {

        if (!isset($data)) {
            return false;
        }

        $sql = '';
        $sql .= 'update posts set ';
        $sql .= 'title = :title,';
        $sql .= 'content = :content,';
        $sql .= 'where id = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':title', $data['title'], \PDO::PARAM_STR);
        $stmt->bindParam(':content', $data['content'], \PDO::PARAM_STR);
        $stmt->bindParam(':id', $data['id'], \PDO::PARAM_INT);
        $ret = $stmt->execute();

        return $ret;
    }
    /**
     * ポストを削除する
     *
     * @param int $id
     * @return bool
     */
    public function deletePost($id)
    {

        if (!is_numeric($id)) {
            return false;
        }

        if ($id <= 0) {
            return false;
        }

        $sql = '';
        $sql .= 'update posts set ';
        $sql .= 'is_deleted = 1,';
        $sql .= 'where id = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $ret = $stmt->execute();

        return $ret;
    }
}
