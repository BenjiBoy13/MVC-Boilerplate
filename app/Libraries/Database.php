<?php

namespace App\Libraries;

/**
 * -------------------------------------------------------------------
 * Database Class
 * -------------------------------------------------------------------
 *
 * The database class offers methods to make and bind queries to the
 * previously configured database
 *
 * @autor Benjamin Gil FLores
 * @version 1.0.0
 */
class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh;
    private $statement;
    private $error;

    /**
     * The database constructor makes the connection to the DB and makes it
     * persist
     *
     * @thorws \PDOException if the connection cant be established
     * @return void;
     */
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

    /**
     * Prepares an sql statement ready to be executed
     *
     * @param $sql
     */
    protected function query($sql)
    {
        $this->statement = $this->dbh->prepare($sql);
    }

    /**
     * Bind the parameters for the previously prepared statement
     *
     * @param $param
     * @param $value
     * @param $type
     */
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

    /**
     * Executes the asked query
     *
     * @return Object
     */
    private function execute()
    {
        return $this->statement->execute();
    }

    /**
     * Gets all of the query results
     *
     * @return Object
     */
    protected function resultSet()
    {
        $this->execute();
        return $this->statement->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Gets the first result of the executed query
     *
     * @return Object
     */
    protected function single()
    {
        $this->execute();
        return $this->statement->fetch(\PDO::FETCH_OBJ);
    }
}

