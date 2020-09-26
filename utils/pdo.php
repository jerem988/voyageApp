<?php 

namespace Utils;

class pdoDB 
{
	private $pdo; 

    public function __construct()
    {
        $ini = parse_ini_file(__DIR__.'/../config.ini');

        try {
            $this->pdo = new \PDO('mysql:host=' . $ini['db_host'] . ';dbname=' . $ini['db_name'] . ';port=' . $ini['db_port'],
            $ini['db_user'], $ini['db_password']);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            $this->pdo->setAttribute(\PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf8"); 
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
    }

    public function getPDO()
    {
        return $this->pdo;
    }

    public function __destruct()
    {
        // Disconnect from DB
        $this->pdo = null;
    }
}

?>