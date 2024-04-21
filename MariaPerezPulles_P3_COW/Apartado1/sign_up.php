<!DOCTYPE html>
<html>

<head>
    <title>Bootstrap Example</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <link rel="stylesheet" href="bootstrap-4.3.1_v2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="bootstrap-4.3.1_v2/js/popper.min.js"></script>
    <script src="bootstrap-4.3.1_v2/js/bootstrap.min.js"></script>
    <script src="bootstrap-4.3.1_v2/js/bootstrap.offcanvas.js"></script>
    <link rel="stylesheet" href="css\styles_signup.css">
</head>

<body>
    <div class="container">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title text-center">Sign Up</h2>
                            <hr>
                            <form action="new_user.php" method="POST">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" name="name" placeholder="Username"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password"
                                        required>
                                </div>
                                <div class="form-check mb-3">
                                    <input type="checkbox" class="form-check-input" id="terms" required>
                                    <label class="form-check-label" for="terms">I accept the Terms of Use & Privacy
                                        Policy</label>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                            </form>
                            <a href="cliente.php" class="btn" style="color:whitesmoke">&lt; Volver</a> <!-- Botón para volver -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>