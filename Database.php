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
     * Creates an event entry using the data provided
     * 
     * It actually just creates an SQL query string and using the query() function returns the result of the data insertion
     */
    function create_entry($title, $date, $description, $location, $color) {
        $sql = "INSERT INTO `calendar_entries` (`date`, `title`, `description`,
                                                `location`, `color`)
                VALUES ('$date', '$title', '$description', '$location', '$color')";

        return $this->query($sql);
    }

    /**
     * Returns all entries (as mysqli_query type) for the entered date
     */
    function get_date_entries($date) {
        $sql = "SELECT * FROM `calendar_entries`
                WHERE `date` LIKE '$date'";

        return $this->query($sql);
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
        $q = $this->query($sql);
        
        return $q->num_rows;
    }

    /**
     * Returns data from table with id equal to id in arguments
     */
    function get_data($table, $id) {
        if($id == "*") {
            $sql = "SELECT * FROM `$table`";
        } else {
            $sql = "SELECT * FROM `$table`
                    WHERE `id` LIKE '$id'";
        }

        return $this->query($sql);
    }

    /**
     * Returns number of entries in the selected table with id equal to id in arguments
     */
    function get_data_count($table, $id) {
        if($id == "*") {
            $sql = "SELECT * FROM `$table`";
        } else {
            $sql = "SELECT * FROM `$table`
                    WHERE `id` LIKE '$id'";
        }

        return $this->get_num_rows($sql);
    }

    /**
     * Checks if user has already registerd a token or not
     */
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

    /**
     * Checks if token exists in table or not
     */
    function check_token($token) {
        $sql = "SELECT * FROM `api_tokens`
                WHERE `token` LIKE '$token'";

        if($this->get_num_rows($sql) == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Saves token to the table
     */
    function save_token($token, $username, $password) {
        $sql = "INSERT INTO `api_tokens` (`token`, `username`, `password`)
                VALUES ('$token', '$username', '$password')";

        return $this->query($sql);
    }
}

?>