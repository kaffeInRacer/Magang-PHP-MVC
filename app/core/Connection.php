<?php


class Configuration
{
    private static $config = [];

    public static function set($key, $value)
    {
        self::$config[$key] = $value;
    }

    public static function get($key)
    {
        return isset(self::$config[$key]) ? self::$config[$key] : null;
    }
}

class Database extends Configuration
{
    private $host;
    private $user;
    private $pass;
    private $dbnm;
    private $port;
    private $dbh;
    private $stmt;

    public function __construct()
    {
        $this->host = $this->get('MySQLHost');
        $this->user = $this->get('MySQLUser');
        $this->pass = $this->get('MySQLPass');
        $this->dbnm = $this->get('MySQLData');
        $this->port = $this->get('MySQLPort');

        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbnm . ';port=' . $this->port . ';charset=utf8';

        $options = [
            PDO::ATTR_PERSISTENT => true, //membuat koneksi selalu terjaga.
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION //tampilkan error pada koneksi database.
        ];

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        $this->stmt->execute();
    }

    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }
}
