<?php
include (dirname(__FILE__) . '/../config.php');
require_once (dirname(__FILE__) . '/../functions.php');
if (!check_session()){
    exit;
}
$value = $_POST['value'];
$name = $_POST['name'];
if (!empty ($value) && !empty($name)){
    $result = get_SQL_array("SELECT * FROM config WHERE name = '$name'");
    if (!empty($result))
        add_SQL_line("UPDATE config SET name = '$name', value = '$value' WHERE name = '$name'");
    else
        add_SQL_line("INSERT INTO config (name, value) VALUES ('$name', '$value')");

}