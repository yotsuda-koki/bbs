<?php

namespace App\Model;

class Base
{

    private static $pdo;
    //インスタンスが生成されていなければ生成し、生成済みであれば生成済みのインスタンスを返却する
    public static function getInstance()
    {
        if (!isset(self::$pdo)) {
            self::$pdo = new \PDO(DSN, DB_USER, DB_PASS);
            //エラーモードを例外にする
            self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            //連想配列としてレコードを取得する
            self::$pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        }

        return self::$pdo;
    }
}
