<html>
<head>
    <title>Power meter</title>
    <script src="inc/jquery-3.2.0.min.js"></script>
    <link rel="stylesheet" href="inc/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="inc/bootstrap/css/bootstrap-theme.min.css">
    <link href="inc/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="inc/sb-admin-2.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <meta name="author" content="Tadas Ustinavičius">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Login to portal
			    <span class="pull-right">
        	    		<a href="https://github.com/Seitanas/esp-12f-power-meter" target="_new">
                    	    	    <span class="fa fa-info-circle glyphicon glyphicon-collapse-up"></span>
                        	</a>
                	    </span>
			</h3>
    			<div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" action="login.php">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="username" autofocus required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="" required>
                                </div>
                                <input type="submit" value="Sign In" class="btn btn-lg btn-success btn-block">
		            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>