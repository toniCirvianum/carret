<?php

namespace App\Helpers;

use PDO;
use PDOException;




class Database
{

    private $connection;
    private $db_host;
    private $db_name;
    private $db_user;
    private $db_password;

    


    public function __construct()
    {
        $this->db_host = $_ENV['DB_HOST'];
        $this->db_name = $_ENV['DB_NAME'];
        $this->db_user = $_ENV['DB_USER'];
        $this->db_password = $_ENV['DB_PASSWORD'];
        $this->setConnection();
    }

    public function setConnection()
    {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        $this->connection= new PDO("mysql:host=$this->db_host;dbname=$this->db_name", $this->db_user, $this->db_password, $options);
        $this->connection->exec('SET CHARACTER SET UTF8');
    }

    public function closeConnection()
    {
        $this->connection = null;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    function queryDataBase($sql, $params = null, $id = false)
    //executa la sentencia sql que li passem per parametre
    {
        if ($this->connection==null) {
            $this->setConnection();
        }
        try {
            $connection = $this->getConnection();
            $statement = $this->getConnection()->prepare($sql);

            if ($params != null) {
                $result = $statement->execute($params);
            } else {
                $result = $statement->execute();
            }
            if ($id) {
                $result = $connection->lastInsertId();
            } else {
                $r = $statement->rowCount();
                $result = $statement->rowCount() > 0 ? $statement : null;
            }
            $this->closeConnection($connection);
            return $result;
        } catch (PDOException $err) {

            echo "error: " . $err->getMessage();
            return null;
        }
    }
}
