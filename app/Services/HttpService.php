<?php


namespace App\Services;

/**
 * -------------------------------------------------------------------
 * HttpService Class
 * -------------------------------------------------------------------
 *
 * The http service manages the magic variables such as $_GET, $_POST and
 * $_SERVER for you, in order to make it easier and safer to get or set
 * values out of this variables and also to prevent you from using them
 * directly
 *
 * @autor Benjamin Gil FLores
 * @version 1.0.0
 */
class HttpService
{
    /**
     * Returns the method of the current requested
     */
    public function getMethod (): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Gets the any posts data and sanitize it preventing any XSS
     * attack
     *
     * @return array
     */
    public function getPostDataAndSanitize (): array
    {
        $_POST = \filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        foreach ($_POST as $key => $postData) {
            $_POST[$key] = \trim($postData);
        }

        return $_POST;
    }
}