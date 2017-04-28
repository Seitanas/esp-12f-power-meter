<?php
include (dirname(__FILE__) . '/../config.php');
require_once (dirname(__FILE__) . '/../functions.php');
if (!check_session()){
    exit;
}
/*
$from = $_GET['from'];
$to = $_GET['to'];
#$marker_size = $_GET['marker_size'];

if (empty ($from))
	$data = get_SQL_array("SELECT * FROM data  WHERE date > DATE_SUB(NOW(), INTERVAL 1 DAY) ORDER BY id");
else {
	if (empty($to))
		$to = date("Y-m-d H:i:s"); 
	$data = get_SQL_array("SELECT * FROM data  WHERE date BETWEEN '$from' AND '$to' ORDER BY id");
}
#if (empty ($marker_size)){

#}
*/
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
if (!empty($start_date) && !empty($end_date)){
    $data = get_SQL_array("SELECT * FROM data  WHERE date >= '$start_date' AND date <= '$end_date' ORDER BY id");
    $marker_size = (round(sizeof($data) / 500));
    if (sizeof($data) < 500)
        $marker_size = 1;
    $x=0;
    $sensor1_data = array();
    $sensor2_data = array();
    $sensor3_data = array();
    $chart_date = array();
    $sensor1_max_val=0;
    $sensor3_max_val=0;
    $sensor3_max_val=0;
    $marker=0;
    while ($x < sizeof($data)){
        ++$marker;
        if ($sensor1_max_val < $data[$x]['sensor1'])
            $sensor1_max_val = $data[$x]['sensor1'];
        if ($sensor2_max_val < $data[$x]['sensor2'])
            $sensor2_max_val = $data[$x]['sensor2'];
        if ($sensor3_max_val < $data[$x]['sensor3'])
            $sensor3_max_val = $data[$x]['sensor3'];
        if ($marker == $marker_size){
            array_push($chart_date,   $data[$x]['date']);
    	    array_push($sensor1_data, $sensor1_max_val);
	        array_push($sensor2_data, $sensor2_max_val);
	        array_push($sensor3_data, $sensor3_max_val);
            $marker=0;
            $sensor1_max_val=0;
            $sensor2_max_val=0;
            $sensor3_max_val=0;
    	}
	    ++$x;
    }
}
#print_r($chart_data);
echo json_encode(array('date' => $chart_date, 'sensor1' => $sensor1_data, 'sensor2' => $sensor2_data, 'sensor3' => $sensor3_data));
#echo json_encode($chart_data);