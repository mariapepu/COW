<!DOCTYPE html>
<html>
	<head>
	<link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/estilo.css" rel="stylesheet" type="text/css"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<title>Nexthouse</title>
	</head>
<body>
    <nav class="navbar bg-primary justify-content-between text-white">
        <img src="next.png">
        <h3>Welcome to Nexthouse, we hope you find yours!</h3>
        <a class="btn btn-outline-light" type="button" href="sign_up.php">Sign up</a>
    </nav>
	<div class="container-fluid">
        <div class="row my-3 mx-1 p-2">
            <form action="http://localhost/COW/S2_3/A2/new_user.php" method="POST">
                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label">Name</label>
                    <div class="col-sm-8">
                        <input type="text" name="name" id="name" class="form-control"
                        placeholder="Name" minlength="1" maxlength="20">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-4 col-form-label">Email</label>
                    <div class="col-sm-8">
                        <input type="email" name="email" id="email" class="form-control"
                        placeholder="Email" minlength="1" maxlength="30">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-sm-4 col-form-label">Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="password" 
                        placeholder="Password" id="password" minlength="5" maxlength="20">
                    </div>
                </div>
                <div>
                    <input type="submit" class="btn btn-primary" value="Sign Up">
                </div>
            </form>
        </div>
        <div class="m-1">
            <h6>© 2022 Nexthouse, Inc.</h6>
        </div>
    </div>
</body>
</html>
