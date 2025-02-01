<?php

namespace App\Model;

class Comments
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
     * ポストに対応するすべてのコメントを取得する
     *
     * @return array
     */
    public function viewCommentsByPostID($postId)
    {

        if (!is_numeric($postId)) {
            return [];
        }

        if ($postId <= 0) {
            return [];
        }

        $sql = '';
        $sql .= 'select ';
        $sql .= 'c.user_id, ';
        $sql .= 'u.name, ';
        $sql .= 'c.content, ';
        $sql .= 'c.create_at, ';
        $sql .= 'c.update_at ';
        $sql .= 'from comments c ';
        $sql .= 'inner join users u on c.user_id = u.id ';
        $sql .= 'where post_id = :post_id ';
        $sql .= 'and c.is_deleted = 0 ';
        $sql .= 'order by update_at';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':post_id', $postId, \PDO::PARAM_INT);
        $stmt->execute();
        $ret = $stmt->fetchAll();

        return $ret;
    }
    /**
     * 指定IDからコメントを取得
     *
     * @param int $Id
     * @return array
     */
    public function viewCommentsByID($id)
    {

        if (!is_numeric($id)) {
            return [];
        }

        if ($id <= 0) {
            return [];
        }

        $sql = '';
        $sql .= 'select ';
        $sql .= 'c.user_id, ';
        $sql .= 'u.name, ';
        $sql .= 'c.content, ';
        $sql .= 'c.create_at, ';
        $sql .= 'c.update_at ';
        $sql .= 'from comments c ';
        $sql .= 'inner join users u on c.user_id = u.id ';
        $sql .= 'where id = :id ';
        $sql .= 'and c.is_deleted = 0 ';
        $sql .= 'order by update_at';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $ret = $stmt->fetchAll();

        return $ret;
    }
    /**
     * コメントする
     *
     * @param array $data
     * @return bool
     */
    public function uploadComment($data)
    {

        if (!isset($data)) {
            return false;
        }

        $sql = '';
        $sql .= 'insert into comments (';
        $sql .= 'user_id,';
        $sql .= 'post_id,';
        $sql .= 'content';
        $sql .= ') values (';
        $sql .= ':user_id,';
        $sql .= ':post_id,';
        $sql .= ':content';
        $sql .= ')';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $data['user_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':post_id', $data['post_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':content', $data['content'], \PDO::PARAM_STR);
        $ret = $stmt->execute();

        return $ret;
    }
    /**
     * コメントを編集する
     *
     * @param array $data
     * @return bool
     */
    public function updateComment($content, $id)
    {

        if (!isset($content)) {
            return false;
        }

        if (!is_numeric($id)) {
            return false;
        }

        if ($id <= 0) {
            return false;
        }

        $sql = '';
        $sql .= 'update comments set ';
        $sql .= 'content = :content,';
        $sql .= 'where id = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':content', $content, \PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $ret = $stmt->execute();

        return $ret;
    }
    /**
     * コメントを削除する
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
        $sql .= 'update comments set ';
        $sql .= 'is_deleted = 1,';
        $sql .= 'where id = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $ret = $stmt->execute();

        return $ret;
    }
}
