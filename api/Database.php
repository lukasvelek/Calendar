<?php

/**
 * Class Database is used to communicate with the database and associated tables
 * 
 * Author: Lukas Velek
 * Version: 2022/8/16
 */
class Database {
    /**
     * Initialize the connection variable
     */
    private $conn;

    /**
     * The constructor; here the connection to the server and specifically database is established and saved
     * to the initialized variable
     */
    function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "calendar");

        $this->check_tables();
    }

    /**
     * Checks tables if they exist if they don't exist then they are created
     */
    function check_tables() {
        $sql = "CREATE TABLE `calendar_entries` IF NOT EXISTS (
            `id` int(16) NOT NULL,
            `date` datetime NOT NULL,
            `title` varchar(1024) NOT NULL,
            `description` varchar(1024) NOT NULL,
            `location` varchar(1024) NOT NULL,
            `color` varchar(1024) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        $this->query($sql);
    }

    /**
     * Returns the result of the query
     */
    function query($sql) {
        return $this->conn->query($sql);
    }

    /**
     * Returns the number of rows that are available for the specified SQL string
     */
    function get_num_rows($sql) {
        $q = $this->conn->query($sql);
        return $q->num_rows;
    }

    function get_data($table, $id) {
        if($id == "*") {
            $sql = "SELECT * FROM `$table`";
        } else {
            $sql = "SELECT * FROM `$table`
                    WHERE `id` LIKE '$id'";
        }

        return $this->query($sql);
    }

    function get_data_count($table, $id) {
        $sql = "SELECT * FROM `$table`
                WHERE `id` LIKE '$id'";

        return $this->get_num_rows($sql);
    }

    function check_user($username, $password) {
        $sql = "SELECT `token` FROM `api_tokens`
                WHERE `username` LIKE '$username'
                AND `password` LIKE '$password'";

        if($this->get_num_rows($sql) >= 1) {
            return true;
        } else {
            return false;
        }
    }

    function check_token($token) {
        $sql = "SELECT * FROM `api_tokens`
                WHERE `token` LIKE '$token'";

        if($this->get_num_rows($sql) == 1) {
            return true;
        } else {
            return false;
        }
    }

    function save_token($token, $username, $password) {
        $sql = "INSERT INTO `api_tokens` (`token`, `username`, `password`)
                VALUES ('$token', '$username', '$password')";

        return $this->query($sql);
    }
}

?>