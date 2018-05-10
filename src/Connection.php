<?php

class Connection {

    /**
     * @var \mysqli
     */
    private static $instance;

    public static function getConnection() {
        try {
            if (!self::$instance) {
                self::$instance = new mysqli('localhost', 'root', 'root', 'eatclean');
            }

            return self::$instance;
        }
        catch (\Exception $exception) {
            print $exception->getMessage();
        }

        return null;
    }

    public static function closeConnection() {
        self::$instance->close();
    }
}
