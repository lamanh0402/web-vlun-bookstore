<?php

/**
 * users_model.php
 * Project: bookshop 
 * Jul 30, 2014 
 * @author khoidv1
 */
require_once 'database.php';

class Users {

    private $conn;

    function __construct() {
        $this->conn = db_connect();
    }

    function select() {
        $sql = "SELECT * FROM `users` ORDER BY `time` DESC";
        $query = mysql_query($sql, $this->conn);
        $result = array();
        while (($row = mysql_fetch_assoc($query))) {
            array_push($result, $row);
        }
        return $result;
    }

    function checkLogin($username, $password) {
        if (!$this->checkExists($username))
            return -1;
        $hashed = sha1($password);
        $sql = "SELECT * FROM users WHERE username = '{$username}' AND password = '{$hashed}'";
        $query = mysql_query($sql, $this->conn);
        $num_rows = mysql_num_rows($query);
        if ($num_rows == 1) {
            $user = mysql_fetch_assoc($query);
            if (privilege() == -1) {
                $_SESSION['account'] = array(
                    "username" => $user['username'],
                    "isadmin" => $user['isadmin'],
                    "timeout"=>time()
                );
            }
            return 1;
        }
        return 0;
    }

    function getUser($username) {
        $username = addslashes($username);
        $sql = "SELECT * FROM users WHERE username = '{$username}'";
        $query = mysql_query($sql, $this->conn);
        if ($query)
            return mysql_fetch_assoc($query);
        return false;
    }

    function conn_close() {
        mysql_close($this->conn);
    }

    function insert($username, $password, $isadmin = null) {
        $username = addslashes($username);
        $hashed = sha1($password);
        if ($this->checkExists($username))
            return -1;
        if (is_null($isadmin))
            $sql = "INSERT INTO users (`username`,`password`) VALUES('{$username}','{$hashed}')";
        else {
            $isadmin = intval($isadmin);
            $sql = "INSERT INTO users (`username`,`password`,`isadmin`) VALUES('{$username}','{$hashed}',{$isadmin})";
        }

        #insert thành công
        if (mysql_query($sql, $this->conn))
            return 1;
        return 0;
    }

    function update($data = array(), $username) {
        $sql = "UPDATE `users` set ";
        $tmp = array();
        foreach ($data as $key => $value) {
            $data[$key] = addslashes($value);
            if (!is_null($value)) {
                if ($key == "password")
                    $value = sha1($value);
                array_push($tmp, "`{$key}`='{$value}'");
            }
        }
        $sql.=implode(", ", $tmp);
        $sql .= " WHERE `username` = '{$username}'";
//        echo $sql;
        #insert thành công
        if (mysql_query($sql, $this->conn))
            return 1;
        return 0;
    }

    function remove($username) {
        $username = addslashes($username);
        $sql = "DELETE FROM `users` WHERE `username` = '{$username}'";
        if (mysql_query($sql, $this->conn))
            return 1;
        return 0;
    }

    private function checkExists($username) {
        $sql = "SELECT * FROM users WHERE username = '{$username}'";
        $query = mysql_query($sql, $this->conn);
        $num_rows = mysql_num_rows($query);
        if ($num_rows == 0)
            return false;
        return true;
    }

}

?>
