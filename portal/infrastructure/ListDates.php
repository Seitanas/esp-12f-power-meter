<?php
include (dirname(__FILE__) . '/../config.php');
require_once (dirname(__FILE__) . '/../functions.php');
if (!check_session()){
    exit;
}
$dates = get_SQL_array("SELECT tbl1.date AS date_last_entry, DATE_FORMAT(tbl1.date, '%Y-%m') AS date_entry FROM data tbl1 INNER JOIN (SELECT MAX(`date`) AS `date` FROM data GROUP BY DATE_FORMAT(`date`, '%Y%m')) tbl2 ON tbl1.`date` = tbl2.`date`");
echo json_encode($dates);