<?php

/**
 * users_model.php
 * Project: bookshop 
 * Jul 30, 2014 
 * @author khoidv1
 */
require_once 'database.php';

class Books {

    private $conn;

    function __construct() {
        $this->conn = db_connect();
    }

    function select($keyword = null) {
        if(is_null($keyword))
            $sql = "SELECT * FROM `books` ORDER BY `bookid`";
        else{
            $keyword = addslashes($keyword);
            $sql = "SELECT * FROM `books` WHERE `title` LIKE '%{$keyword}%' OR `description` LIKE '%{$keyword}%' ORDER BY `bookid`";
        }
        $query = mysql_query($sql, $this->conn);
        $result = array();
        while (($row = mysql_fetch_assoc($query))) {
            array_push($result, $row);
        }
        return $result;
    }

    function getBook($bookId) {
        $sql = "SELECT * FROM `books` WHERE `bookid` = '{$bookId}'";
        $query = mysql_query($sql, $this->conn);
        if ($query)
            return mysql_fetch_assoc($query);
        return false;
    }

    function update($data = array(), $bookId) {
        $bookId = intval($bookId);
        $sql = "UPDATE `books` set ";
        $tmp = array();
        foreach ($data as $key => $value) {
            $data[$key] = addslashes($value);
            if (!is_null($value)) {
                array_push($tmp, "`{$key}`='{$value}'");
            }
        }
        $sql.=implode(", ", $tmp);
        $sql .= " WHERE `bookid` = '{$bookId}'";
        #insert thành công
        if (mysql_query($sql, $this->conn))
            return 1;
        return 0;
    }

    function insert($data) {
        foreach ($data as $key => $value) {
            if (!is_null($value)) {
                $data[$key] = addslashes($value);
            }
        }
        $sql = "INSERT INTO `books` (`title`,`price`,`description`,`image`) VALUE('{$data['title']}','{$data['price']}','{$data['description']}','{$data['image']}')";
//        echo $sql;
        #insert thành công
        if (mysql_query($sql, $this->conn))
            return 1;
        return 0;
    }

    function remove($bookId) {
        $bookId = intval($bookId);
        $sql = "DELETE FROM `books` WHERE `bookid` = '{$bookId}'";
        if (mysql_query($sql, $this->conn))
            return 1;
        return 0;
    }

    function conn_close() {
        mysql_close($this->conn);
    }

}

?>
