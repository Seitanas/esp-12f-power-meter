<?php
include (dirname(__FILE__) . '/../config.php');
require_once (dirname(__FILE__) . '/../functions.php');
if (!check_session()){
    exit;
}
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
if (!empty($start_date) && !empty($end_date)){
    $start_date = $start_date . " 00:00:00";
    $end_date = $end_date . " 23:59:59";
    $dates = get_SQL_array("SELECT DATE_FORMAT(tbl1.date, '%Y-%m-%d %H') AS date_entry FROM data tbl1 INNER JOIN (SELECT MAX(`date`) AS `date` FROM data WHERE date >= '$start_date' AND date <= '$end_date' GROUP BY DATE_FORMAT(`date`, '%Y%m%d%H')) tbl2 ON tbl1.`date` = tbl2.`date`");
}
echo json_encode($dates);