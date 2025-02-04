<?php

namespace App\Util;

require_once('../../App/config.php');

use App\Model\Base;
use App\Model\Users;
use Exception;

class Validation
{
    /**
     * アカウントIDのバリデーションチェック
     *
     * @param string $accountId
     * @return bool
     */
    public static function isValidUserAccountID($accountId)
    {
        if (empty($accountId)) {
            $_SESSION['msg']['error'] = 'アカウントIDを入力してください。';
            return false;
        }

        try {
            $base = Base::getInstance();
            $db = new Users($base);
            if (!$db->isValidAccountId($accountId)) {
                $_SESSION['msg']['error'] = '同じアカウントIDが存在します';
                return false;
            }
        } catch (Exception $e) {
            header('Location :' . ERROR_URL);
            exit();
        }

        return true;
    }
    /**
     * ユーザー名のバリデーションチェック
     *
     * @param string $name
     * @return bool
     */
    public static function isValidUserName($name)
    {
        if (empty($name)) {
            $_SESSION['msg']['error'] = 'ユーザー名を入力してください。';
            return false;
        }

        try {
            $base = Base::getInstance();
            $db = new Users($base);
            if (!$db->isValidName($name)) {
                $_SESSION['msg']['error'] = '同じユーザー名が存在します';
                return false;
            }
        } catch (Exception $e) {
            header('Location :' . ERROR_URL);
            exit();
        }

        return true;
    }
    /**
     * パスワードのバリデーションチェック
     *
     * @param string $pass
     * @return bool
     */
    public static function isValidUserPass($pass)
    {
        if (strlen($pass) < 7) {
            $_SESSION['msg']['error'] = 'パスワードが8文字以上で入力してください。';
            return false;
        }
        return true;
    }
    /**
     * メールアドレスのバリデーションチェック
     *
     * @param string $email
     * @return bool
     */
    public static function isValidUserEmail($email)
    {
        if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
            $_SESSION['msg']['error'] = '正しいメールアドレスを入力してください。';
            return false;
        }

        try {
            $base = Base::getInstance();
            $db = new Users($base);
            if (!$db->isValidEmail($email)) {
                $_SESSION['msg']['error'] = '同じメールアドレスが存在します';
                return false;
            }
        } catch (Exception $e) {
            header('Location :' . ERROR_URL);
            exit();
        }

        return true;
    }
    /**
     * アカウントIDのバリデーションチェック
     *
     * @param string $accountId
     * @param int $id
     * @return bool
     */
    public static function isValidEditUserAccountID($accountId, $id)
    {
        if (empty($accountId)) {
            $_SESSION['msg']['error'] = 'アカウントIDを入力してください。';
            return false;
        }

        try {
            $base = Base::getInstance();
            $db = new Users($base);
            if (!$db->isValidEditAccountId($accountId, $id)) {
                $_SESSION['msg']['error'] = '同じアカウントIDが存在します';
                return false;
            }
        } catch (Exception $e) {
            header('Location :' . ERROR_URL);
            exit();
        }

        return true;
    }
    /**
     * ユーザー名のバリデーションチェック
     *
     * @param string $name
     * @param int $id
     * @return bool
     */
    public static function isValidEditUserName($name, $id)
    {
        if (empty($name)) {
            $_SESSION['msg']['error'] = 'ユーザー名を入力してください。';
            return false;
        }

        try {
            $base = Base::getInstance();
            $db = new Users($base);
            if (!$db->isValidEditName($name, $id)) {
                $_SESSION['msg']['error'] = '同じユーザー名が存在します';
                return false;
            }
        } catch (Exception $e) {
            header('Location :' . ERROR_URL);
            exit();
        }

        return true;
    }
    /**
     * メールアドレスのバリデーションチェック
     *
     * @param string $email
     * @param int $id
     * @return bool
     */
    public static function isValidEditUserEmail($email, $id)
    {
        if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
            $_SESSION['msg']['error'] = '正しいメールアドレスを入力してください。';
            return false;
        }

        try {
            $base = Base::getInstance();
            $db = new Users($base);
            if (!$db->isValidEditEmail($email, $id)) {
                $_SESSION['msg']['error'] = '同じメールアドレスが存在します';
                return false;
            }
        } catch (Exception $e) {
            header('Location :' . ERROR_URL);
            exit();
        }

        return true;
    }
}
