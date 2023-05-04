<?php

/**
 * database.php
 * Project: bookshop 
 * Jul 30, 2014 
 * @author khoidv1
 */

function db_connect() {
    $conn = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die('Could not connect: ' . mysql_error());
    mysql_set_charset("UTF8", $conn);
    mysql_select_db(DB_DATA) or die('Could not connect: ' . mysql_error());
    return $conn;
}
function db_closed($conn){
    mysql_close($conn);
}
?>
