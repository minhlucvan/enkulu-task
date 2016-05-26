<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="shortcut icon" type="image/png" href="public/favicon.ico"/>
	<title>User Management</title>
	<link rel="stylesheet" type="text/css" href="public/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="public/css/main.css">
	<script type="text/javascript" src="public/js/jquery-1.9.1.js"/></script>	
	<script type="text/javascript" src="public/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>

	<div class="container">
	<div class="alert alert-sm alert-abs alert-success alert-dismissible fade" role="alert" id="notify">
  	<button type="button" class="close" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  	</button>
  	<span class="content">
  		<strong>Holy guacamole!</strong> You should check in on some of those fields below.
  	</span>
	</div>
		<h1 class="center bold mt5">user management</h1>
		<p>1 to 10 of 11 records</p>
		<table id="user-list" class="table table-bordered table-striped">
		    <thead>
		      <tr>
		        <th>#</th>
		        <th>name</th>
		        <th>Email</th>
		        <th>phone</th>
		        <th>avatar</th>
		        <th>action</th>
		      </tr>
		    </thead>
		    <tbody>
		      <tr id="new-row">
		        <td>1</td>
		        <td>Doe</td>
		        <td>john@example.com</td>
		        <td>0969407641</td>
		        <td class="centered"><img class="avatar" src="public/img/default_avatar.png"></td>
		        <td class="centered">
		        	<button class="btn btn-success btn-edit">
		        		<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
		        	</button>
					<button class="btn btn-danger btn-delete">
						<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
					</button>
		        </td>
		      </tr>
		    </tbody>
		  </table>
		  <div class="tool-bar">
		  <div class="pagger">
		  	<div class="btn-group">
		  		<button class="btn btn-default"><</button>
		  		<button onclick="tableUsers.page(1)" class="btn btn-primary">1</button>
		  		<button onclick="tableUsers.page(2)" class="btn btn-default">2</button>
		  		<button onclick="tableUsers.page(3)" class="btn btn-default">3</button>
		  		<button class="btn btn-default">...</button>
		  		<button class="btn btn-default">></button>
		  	</div>
		  </div>
			<button class="btn btn-warning pull-right" onclick="modalUser.addUser()">
				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
				<span>add user</span>
			</button>
		</div>
		  
	<!-- Modal -->
  <div class="modal fade" id="user-modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">User Form</h4>
        </div>
        <div class="modal-body">
          <form id="user-form">
		  <fieldset class="form-group">
		    <label for="name">name</label>
		    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
		    <small class="text-muted" for="name"></small>
		  </fieldset>

		  <fieldset class="form-group">
		    <label for="email">Email address</label>
		    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
		    <small class="text-muted" for="email"></small>
		  </fieldset>
		  <fieldset class="form-group">
		    <label for="phone">phone</label>
		    <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone">
		    <small class="text-muted" for="phone"></small>
		  </fieldset>
		    <fieldset class="form-group">
		    <label for="avatar">avatar</label><br>
		    	<div class="row">
		    		<div class="col-xs-4">
		    			<input type="file" id="avatar" name="avatar" placeholder="Enter email">
		    			<small class="text-muted" for="avatar"></small>
		    		</div>
		    		<div class="col-xs-8">
		    		</div>
		    	</div>
		  </fieldset>
		</form>
        </div>
        <div class="modal-footer">
  			<button type="submit" id="user-submit" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
	</div>
	</div>

	<!-- Modal -->
  <div class="modal fade" id="confrim-modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete Confrimr</h4>
        </div>
        <div class="modal-body">
          do you sure to delete this user?
        </div>
        <div class="modal-footer">
  			<button type="submit" class="btn btn-danger btn-confrim">delete</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
        </div>
      </div>
	</div>
	</div>
	</div>
	<script type="text/javascript" src="public/js/main.js"></script>
</body>
</html>