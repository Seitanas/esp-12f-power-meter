<?php
include (dirname(__FILE__) . '/../config.php');
require_once (dirname(__FILE__) . '/../functions.php');
if (!check_session()){
    exit;
}
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$full = $_POST['full'];
if (!empty($start_date) && !empty($end_date)){
    if (isset($full)) {
        if ($start_date == 'currmonth'){
            $start_date = date("Y-m-01 00:00:00");
            $end_date = date("Y-m-d H:i:s");
        }
        else {
            $start_date = $start_date . "-01 00:00:00";
            $end_date = date("Y-m-t", strtotime($end_date)) . " 23:59:59";
        }
    }
    $data = get_SQL_array("SELECT * FROM data  WHERE date >= '$start_date' AND date <= '$end_date' ORDER BY id");	
    $x = 0;
    $y = 0;
    $sensor = array();
    while ($x < sizeof($data)){
        $sensor[0] = $sensor[0] + $data[$x]['sensor1'];
        $sensor[1] = $sensor[1] + $data[$x]['sensor2'];
        $sensor[2] = $sensor[2] + $data[$x]['sensor3'];
        ++$x;
    }
    $start_time = new DateTime($data[0]['date']);
    $end_time = new DateTime($data[sizeof($data) - 1]['date']);
    $time_between = $start_time -> diff($end_time);
    $interval = ($time_between->format('%d') * 24) + $time_between->format('%H') + ($time_between->format('%i') / 60) + ($time_between->format('%s') / 3600);
    $y = 0;
    $data_size = sizeof($data);
    # calculate average wattage:
    while ($y < 3){
        $sensor[$y] = $sensor[$y] / $data_size;
        ++$y;
    }
    # calculate kWh
    $y = 0;
    while ($y < 3){
        $sensor[$y] = round($sensor[$y] * $interval / 1000, 3);
        ++$y;
    }
    #build reply array:
    $y = 0;
    $reply_array = array();
    while ($y < 3){
        $reply_array['sensor-' . ($y + 1)] = array('from' => $start_date, 'to' => $end_date, 'kWh' => $sensor[$y]);
        ++$y;
    }
}
echo json_encode($reply_array);
