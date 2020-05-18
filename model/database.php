<?php
class Database {

    private static $dsn = 'mysql:host=remotemysql.com;dbname=YYwPpXym72';
    private static $username = 'YYwPpXym72';
    private static $password = 'EhiwKpeRFd';
    private static $db;

    private function __construct() {}

    public static function getDB () {
        if (!isset(self::$db)) {
            try {
                self::$db = new PDO(self::$dsn,
                                     self::$username,
                                     self::$password);
            } catch (PDOException $e) {
                $error_message = $e->getMessage();
                include('errors/db_error_connect.php');
                exit();
            }
        }
        return self::$db;
    }
}
?>