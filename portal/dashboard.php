<?php
include (dirname(__FILE__) . '/config.php');
require_once (dirname(__FILE__) . '/functions.php');
if (!check_session()){
    header("Location: /");
    exit;
}
$reply = get_SQL_array("SELECT * FROM config");
$sensor_config = array();
foreach ($reply as $value)
    $sensor_config[$value['name']] = $value['value'];
if (!$sensor_config['total-name'])
    $sensor_config['total-name']='Total';
?>
<html>
<head>
    <title>Power meter</title>
    <script src="inc/jquery-3.2.0.min.js"></script>
    <script src="inc/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="inc/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="inc/bootstrap/css/bootstrap-theme.min.css">
    <link href="inc/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="inc/bootstrap/js/bootstrap.min.js"></script>
    <script src="inc/hammer.min.js"></script>
    <script src="inc/Chart.js"></script>
    <script src="inc/chartjs-plugin-zoom.min.js"></script>
    <script src="inc/power-meter.js"></script>
    <link href="inc/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet" type="text/css">
    <script src="inc/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <link href="inc/power-meter.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="inc/jquery-ui.min.css">
    <meta name="author" content="Tadas Ustinavičius">
    <style>
		canvas {
			width: 100%;
			height: auto;
		}
	</style>
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
      			<a class="navbar-brand" href="#">Power usage</a>
		    </div>
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		    	<ul class="nav navbar-nav navbar-right">
                    <input type="hidden" id="sensor1-name" value="<?php echo $sensor_config['sensor1-name'];?>">
                    <input type="hidden" id="sensor2-name" value="<?php echo $sensor_config['sensor2-name'];?>">
                    <input type="hidden" id="sensor3-name" value="<?php echo $sensor_config['sensor3-name'];?>">
		        	<li><a href="logout.php">Logout</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4>
                            Date picker

                        </h4>
                    </div>
                    <div class="panel-body">
                        <div>
                            <i class="text-muted">Interval: </i>
                            <i id="interval-value"></i>
                            <i class="fa fa-spinner fa-pulse fa-2x fa-fw text-primary hidden" id="spinner"></i>
                            <span class="pull-right"><a class="fa fa-refresh fa-1g text-default" id="refresh" href="#"></a></span>
                        </div>
                        <div><i class="text-muted">Date:</i></div>
                        <div id="date-slider"></div>
                        <div><i class="text-muted">Day:</i></div>
                        <div id="day-slider"></div>
                        <div><i class="text-muted">Hour:</i></div>
                        <div id="hour-slider"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-3">
						<div class="panel panel-info">
							<div class="panel-heading">
                                <h4 id="sensor1-text">
                                    <a id="sensor1-name" class="editable editable-pre-wrapped editable-click sensor-name" data-pk="10" data-type="text" href="#"><?php echo $sensor_config['sensor1-name'];?></a>
                                    <i class="fa fa-spinner fa-pulse fa-1x fa-fw text-info kwh-spinner"></i>
                                </h4>
							</div>
							<div class="panel-body">
								<p>
                                    <h5 class="text-center">
                                        <small>
                                            <a id="sensor1-description" class="editable editable-pre-wrapped editable-click sensor-description" data-pk="0" data-type="textarea" href="#"><?php echo $sensor_config['sensor1-description'];?></a>
                                        </small>
                                    </h5>
                                </p>
								<p><h1 class="text-center" id="sensor-1"></h1></p>
								<p><h5 class="text-center"><small id="sensor-1-period"></small></h5></p>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="panel panel-success">
							<div class="panel-heading">
								<h4 id="sensor2-text">
                                    <a id="sensor2-name" class="editable editable-pre-wrapped editable-click sensor-name" data-pk="11" data-type="text" href="#"><?php echo $sensor_config['sensor2-name'];?></a>
                                    <i class="fa fa-spinner fa-pulse fa-1x fa-fw text-success kwh-spinner"></i>
                                </h4>
							</div>
							<div class="panel-body">
								<p>
                                    <h5 class="text-center">
                                        <small>
                                            <a id="sensor2-description" class="editable editable-pre-wrapped editable-click sensor-description" data-pk="1" data-type="textarea" href="#"><?php echo $sensor_config['sensor2-description'];?></a>
                                        </small>
                                    </h5>
                                </p>
								<p><h1 class="text-center" id="sensor-2"></h1></p>
								<p><h5 class="text-center"><small id="sensor-2-period"></small></h5></p>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="panel panel-warning">
							<div class="panel-heading">
								<h4 id="sensor3-text">
                                    <a id="sensor3-name" class="editable editable-pre-wrapped editable-click sensor-name" data-pk="12" data-type="text" href="#"><?php echo $sensor_config['sensor3-name'];?></a>
                                    <i class="fa fa-spinner fa-pulse fa-1x fa-fw text-warning kwh-spinner"></i>
                                </h4>
							</div>
							<div class="panel-body">
								<p>
                                    <h5 class="text-center">
                                        <small>
                                            <a id="sensor3-description" class="editable editable-pre-wrapped editable-click sensor-description" data-pk="2" data-type="textarea" href="#"><?php echo $sensor_config['sensor3-description'];?></a>
                                        </small>
                                    </h5>
                                </p>
								<p><h1 class="text-center" id="sensor-3"></h1></p>
								<p><h5 class="text-center"><small id="sensor-3-period"></small></h5></p>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="panel panel-warning">
							<div class="panel-heading">
								<h4 id="total-text">
                                    <a id="total-name" class="editable editable-pre-wrapped editable-click sensor-name" data-pk="13" data-type="text" href="#"><?php echo $sensor_config['total-name'];?></a>
                                    <i class="fa fa-spinner fa-pulse fa-1x fa-fw text-warning kwh-total-spinner"></i>
                                </h4>
							</div>
							<div class="panel-body">
								<p>
                                    <h5 class="text-center">
                                        <small>
                                            <a id="total-description" class="editable editable-pre-wrapped editable-click sensor-description" data-pk="3" data-type="textarea" href="#"><?php echo $sensor_config['total-description'];?></a>
                                        </small>
                                    </h5>
                                </p>
								<p><h1 class="text-center" id="total"></h1></p>
								<p><h5 class="text-center"><small id="total-period"></small></h5></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">	
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<div class="panel panel-default">
					<div class="panel-heading">
						Power graph <span class="pull-right"><a class="fa fa-spinner fa-pulse fa-1x fa-fw text-default" id="chart-spinner" href="#"></a></span>
					</div>
					<div class="panel-body">
					    <div><canvas id="power_chart"></canvas></div>
					</div>
				</div>
			</div>
			<div class="col-md-1"></div>
		</div>
	</div>
</body>
</html>