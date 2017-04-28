<?php
function SQL_connect(){
    include (dirname(__FILE__).'/config.php');
    $mysql_connection=mysqli_connect($mysql_host,$mysql_user,$mysql_pass);
    $mysql_connection->set_charset('utf8');
    mysqli_select_db($mysql_connection, $mysql_db);
    return $mysql_connection;
}
//##############################################################################
function add_SQL_line($sql_line){
    $mysql_connection=SQL_connect();
    mysqli_query($mysql_connection, $sql_line) or die (mysqli_error($mysql_connection));
    mysqli_close($mysql_connection);
    return 0;
}
//##############################################################################
function get_SQL_line($sql_line){
    $mysql_connection=SQL_connect();
    $result = mysqli_fetch_row(mysqli_query($mysql_connection, $sql_line));
    mysqli_close($mysql_connection);
    return $result;
}
//##############################################################################
function get_SQL_Array($sql_line){
    $query_array=array();
    $mysql_connection=SQL_connect();
    $q_string = mysqli_query($mysql_connection, $sql_line)or die (mysqli_error($mysql_connection));
    while ($row=mysqli_fetch_array($q_string, MYSQLI_ASSOC)){
        $query_array[]=$row;
    }
    mysqli_close($mysql_connection);
    return $query_array;
}
//##############################################################################
function check_session(){
    if (session_status() == PHP_SESSION_NONE) 
        session_start();
    if (isset($_SESSION['logged']))
        return $_SESSION['logged'];
    else return 0;
}
//##############################################################################
function close_session(){
    if (session_status() == PHP_SESSION_NONE) 
        session_start();
    $_SESSION['logged']='';
}