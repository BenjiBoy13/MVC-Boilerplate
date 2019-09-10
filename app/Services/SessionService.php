<?php


namespace App\Services;

/**
 * -------------------------------------------------------------------
 * SessionService Class
 * -------------------------------------------------------------------
 *
 * The session service manages the magic php variable SESSION and lets
 * you set a new session or get a session also it initialize the sessions
 *
 * @autor Benjamin Gil FLores
 * @version 1.0.0
 */
class SessionService
{
    /**
     * The constructor fot the service initialize the sessions
     *
     * @return void
     */
    public function __construct()
    {
        \session_start();
    }

    /**
     * Gets a session property and returns it
     *
     * @param $sessionName
     * @return String
     */
    public function getSession($sessionName)
    {
        return $_SESSION[$sessionName];
    }

    /**
     * Allocates a new variable inside the session magic
     * variable
     *
     * @param $sessionName
     * @param $value
     * @return void
     */
    public function setSession($sessionName, $value)
    {
        $_SESSION[$sessionName] = $value;
    }
}