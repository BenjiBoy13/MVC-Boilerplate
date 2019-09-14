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
        ini_set('session.name', SITENAME . "SID");
        \session_start();

        // Every 30min we regenerate the session id to prevent session fixation
        if (!isset($_SESSION['regenerate'])) {
            $_SESSION['regenerate'] = time();
        } else if(time() - $_SESSION['regenerate'] > 1800) {
            \session_regenerate_id();
            unset($_SESSION['regenerate']);
        }
    }

    /**
     * Gets a session property and returns it
     *
     * @param $id
     * @return String
     */
    public function getSession($id): string
    {
        return isset($_SESSION[$id]) ? $_SESSION[$id] : '';
    }

    /**
     * Allocates a new variable inside the session magic
     * variable
     *
     * @param $id
     * @param $value
     * @return void
     */
    public function setSession($id, $value): void
    {
        $_SESSION[$id] = $value;
    }

    /**
     * Deletes the active session
     *
     * @return void
     */
    public function destroySession(): void
    {
        unset($_SESSION);
        \session_destroy();
    }
}