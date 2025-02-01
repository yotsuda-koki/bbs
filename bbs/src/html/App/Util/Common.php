<?php

namespace App\Util;

class Common
{
    /**
     * サニタイズ
     *
     * @param array $before サニタイズ前にPOST配列
     * @return array サニタイズ後のPOST配列
     */
    public static function sanitize($before)
    {
        $after = [];
        foreach ($before as $k => $v) {
            $after[$k] = htmlspecialchars($v, ENT_QUOTES, 'utf-8');
        }
        return $after;
    }
    /**
     * 32文字のランダムな文字列を作成する
     *
     * @param integer $length
     * @return string
     */
    public static function makeRandomString(int $length = 32): string
    {
        return bin2hex(openssl_random_pseudo_bytes($length));
    }
    /**
     * ワンタイムトークンを作成する
     *
     * @param string $tokenName セッションに保存するトークンのキーの名前'token'
     * @return string
     */
    public static function generateToken(string $tokenName = 'token')
    {
        $token = self::makeRandomString();
        $_SESSION[$tokenName] = $token;
        return $token;
    }
    /**
     * ワンタイムトークンのチェック
     *
     * @param string|null $token 送信されてきたトークン
     * @param string $tokenName セッションに保存されているトークンのキーの名前
     * @return boolean
     */
    public static function isValidToken(?string $token, string $tokenName = 'token'): bool
    {
        if (!isset($_SESSION[$tokenName]) || $_SESSION[$tokenName] !== $token) {
            return false;
        }
        return true;
    }
}
