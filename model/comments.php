<?php

/**
 * comments.php
 * Project: bookstore 
 * Aug 4, 2014 
 * @author khoidv1
 */
require_once 'database.php';

class Comments {

    private $conn;

    function __construct() {
        $this->conn = db_connect();
    }

    function select() {
        $sql = "SELECT * FROM `comments` ORDER BY `commentid` DESC";
        $query = mysql_query($sql, $this->conn);
        $result = array();
        while (($row = mysql_fetch_assoc($query))) {
            array_push($result, $row);
        }
        return $result;
    }

    function getComment($bookId) {
        $bookId = intval($bookId);
        $sql = "SELECT * FROM `comments` WHERE `bookid` = '{$bookId}' ORDER BY `commentid` DESC";
        $query = mysql_query($sql, $this->conn);
        $result = array();
        while (($row = mysql_fetch_assoc($query))) {
            array_push($result, $row);
        }
        return $result;
    }

    function insert($bookId, $username, $comment) {
        $comment = addslashes($comment);
        $sql = "INSERT INTO `comments` (`username`,`bookid`,`comment`) VALUES ('{$username}','{$bookId}','{$comment}')";
        if (mysql_query($sql, $this->conn))
            return 1;
        return 0;
    }

    function del($commentId, $bookId, $username = null) {
        $commentId = intval($commentId);
        $bookId = intval($bookId);
        if (!is_null($username))
            $sql = "DELETE FROM `comments` WHERE `commentid` = {$commentId} AND `bookid` = {$bookId} AND  `username` = '{$username}'";
        else
            $sql = "DELETE FROM `comments` WHERE `commentid` = {$commentId} AND `bookid` = {$bookId}";
//        echo $sql;
        if (mysql_query($sql, $this->conn))
            return 1;
        return 0;
    }

    function conn_close() {
        mysql_close($this->conn);
    }

}

?>
