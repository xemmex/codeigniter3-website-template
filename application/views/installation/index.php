<!DOCTYPE html>
<html lang="en">
    <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Installation </title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
	<style type="text/css">
	    body {
		padding-top: 30px;
		padding-bottom: 30px;
	    }
	    .label-as-badge {
		float:right;
		border-radius: 1em;
	    }
	</style>
    </head>

    <body role="document">

	<div class="container theme-showcase" role="main">

	    <div class="jumbotron">
		<h1>Installation Setup v1.0</h1>
	    </div>

	    <div class="col-sm-6">

		<h2><i class="glyphicon glyphicon-cog"></i> Setup Requirements</h2>

		<ul class="list-group">
		    <?php foreach ( $requeriments as $item ) : ?>
    		    <li class="list-group-item">
			    <?= $item['name']; ?>
			    <?php if ( $item['result'] ) : ?>
				<span class="label label-success label-as-badge">success</span>
			    <?php else: ?>
				<span class="label label-danger label-as-badge">danger</span>
			    <?php endif; ?>
    		    </li>
		    <?php endforeach; ?>
		</ul>

	    </div>

	    <div class="col-sm-6">
		<h2><i class="glyphicon glyphicon-folder-open"></i>  Permissions</h2>

		<ul class="list-group">
		    <?php foreach ( $permissions as $item ) : ?>
    		    <li class="list-group-item">
			    <?= $item['name']; ?>
			    <?php if ( $item['result'] ) : ?>
				<span class="label label-success label-as-badge">writable</span>
			    <?php else: ?>
				<span class="label label-danger label-as-badge">unwritable</span>
			    <?php endif; ?>
    		    </li>
		    <?php endforeach; ?>
		</ul>


	    </div>

	    <div class="col-sm-6">

		<h2><i class="glyphicon glyphicon-tasks"></i>  Database Settings</h2>

		<div class="form-group">
		    <div class="input-group">
			<span class="input-group-addon glyphicon glyphicon-hdd"></span>
			<input type="text" required="" autocomplete="off" placeholder="Database Host" class="form-control" name="db_host" value="">
		    </div>
		</div>

		<div class="form-group">
		    <div class="input-group">
			<span class="input-group-addon glyphicon glyphicon-user"></span>
			<input type="text" required="" autocomplete="off" placeholder="Database Username" class="form-control" name="db_username" value="">
		    </div>
		</div>

		<div class="form-group">
		    <div class="input-group">
			<span class="input-group-addon glyphicon glyphicon-lock"></span>
			<input type="text" required="" autocomplete="off" placeholder="Database Password" class="form-control" name="db_password" value="">
		    </div>
		</div>

		<div class="form-group">
		    <div class="form-group">
			<div class="input-group">
			    <span class="input-group-addon glyphicon glyphicon-tasks"></span>
			    <input type="text" required="" autocomplete="off" placeholder="Database Name" class="form-control" name="database" value=""><br>
			</div>

		    </div>
		</div>

	    </div>

	    <div class="col-sm-6">

		<h2><i class="glyphicon glyphicon-lock"></i>  Security Settings</h2>

		<div class="form-group">
		    <div class="input-group">
			<span class="input-group-addon glyphicon glyphicon-eye-open"></span>
			<input type="text" required="" autocomplete="off" placeholder="Codeigniter Encryption Key" class="form-control" name="db_password" value="">
		    </div>
		</div>

		<div class="form-group">
		    <div class="input-group">
			<span class="input-group-addon glyphicon glyphicon-envelope"></span>
			<input type="text" required="" autocomplete="off" placeholder="Administrator E-mail" class="form-control" name="db_password" value="">
		    </div>
		</div>

		<div class="form-group">
		    <div class="input-group">
			<span class="input-group-addon glyphicon glyphicon-lock"></span>
			<input type="text" required="" autocomplete="off" placeholder="Administrator Password" class="form-control" name="db_password" value="">
		    </div>
		</div>

	    </div>

	    <div class="clearfix"></div>

	    <hr>

	    <div class="col-sm-12">
		<button class="btn btn-lg btn-success pull-right" type="submit">Install</button>
	    </div>

	</div>



	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    </body>
</html>