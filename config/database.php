<?php
class Database
{
    private static $host = 'db';
    private static $db   = 'cadastroimovel';
    private static $user = 'marcielle';
    private static $pass = '123456';
    private static $port = '5432';

    public static function connect()
    {
        try {
            $dsn = "pgsql:host=" . self::$host . ";port=" . self::$port . ";dbname=" . self::$db;
            $pdo = new PDO($dsn, self::$user, self::$pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }
}
