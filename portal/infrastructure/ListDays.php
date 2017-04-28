<?php
include (dirname(__FILE__) . '/../config.php');
require_once (dirname(__FILE__) . '/../functions.php');
if (!check_session()){
    exit;
}
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
if (!empty($start_date) && !empty($end_date)){
    if($start_date == $end_date){// if we are checking single month, by default select all days
        $date_entry = explode("-", $start_date);
        $start_date = $date_entry[0] . "-" . $date_entry[1] . "-01 00:00:00";
        $end_date = $date_entry[0] . "-" . $date_entry[1] . "-31 23:59:99";
    }
    $dates = get_SQL_array("SELECT DATE_FORMAT(tbl1.date, '%Y-%m-%d') AS date_entry FROM data tbl1 INNER JOIN (SELECT MAX(`date`) AS `date` FROM data WHERE date >= '$start_date' AND date <= '$end_date' GROUP BY DATE_FORMAT(`date`, '%Y%m%d')) tbl2 ON tbl1.`date` = tbl2.`date`");
}
echo json_encode($dates);