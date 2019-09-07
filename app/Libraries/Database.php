<?php

namespace App\Libraries;

class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh;
    private $statement;
    private $error;

    public function __construct()
    {
        //set our dsn
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            \PDO::ATTR_PERSISTENT => true,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        );

        //Create PDO instance
        try
        {
            $this->dbh = new \PDO($dsn, $this->user, $this->pass, $options);
        }
        catch (\PDOException $e)
        {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    //Prepare statements with query
    protected function query($sql)
    {
        $this->statement = $this->dbh->prepare($sql);
    }

    //Bind values
    protected function bind($param, $value, $type = null)
    {
        if (is_null($type))
        {
            switch (true)
            {
                case is_int($value):
                    $type = \PDO::PARAM_INT;
                    break;

                case is_bool($value):
                    $type = \PDO::PARAM_BOOL;
                    break;

                case is_null($value):
                    $type = \PDO::PARAM_NULL;
                    break;

                default:
                    $type = \PDO::PARAM_STR;
                    break;
            }
        }

        $this->statement->bindValue($param, $value, $type);
    }

    //Execute the prepared statement
    private function execute()
    {
        return $this->statement->execute();
    }

    //Get result set as array of objects
    protected function resultSet()
    {
        $this->execute();
        return $this->statement->fetchAll(\PDO::FETCH_OBJ);
    }

    //Get single content
    protected function single()
    {
        $this->execute();
        return $this->statement->fetch(\PDO::FETCH_OBJ);
    }

    //Get row count
    protected function rowCount()
    {
        return $this->statement->rowCount();
    }
}

