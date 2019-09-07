<?php


namespace App\Services;


class SessionManager
{
    public function __construct()
    {
        \session_start();
    }

    public function getSession($sessionName)
    {
        return $_SESSION[$sessionName];
    }

    public function setSession($sessionName, $value)
    {
        $_SESSION[$sessionName] = $value;
    }
}