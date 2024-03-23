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
    <link rel="stylesheet" href="styles_signup.css">
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
                            <div>
                                <?php
                                try {
                                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                        $name = htmlspecialchars($_POST["name"]);
                                        $email = $_POST["email"];
                                        $pwd = $_POST["password"];
                                        $regex_name = "/^[a-zA-Z -]{1,20}$/"; // Max: 20 characters
                                        $regex_email = "/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/";

                                        if (!preg_match($regex_name, $name)) {
                                            throw new Exception('Name was incorrectly fullfilled!');
                                        } elseif (!preg_match($regex_email, $email)) {
                                            throw new Exception('Email was incorrectly fullfilled!');
                                        } elseif (!strlen($pwd) > 5) {
                                            throw new Exception('Password must contain at least 5 characters!');
                                        }
                                    } else {
                                        throw new Exception('Requested method was not a POST!');
                                    }
                                } catch (Exception $e) {
                                    die ('Message: ' . $e->getMessage());
                                }
                                // Connection to MySQL
                                $servername = "localhost";
                                $username = "root";
                                $password = "";

                                try {
                                    $conn = new PDO("mysql:host=$servername;dbname=simpsons", $username, $password);
                                    // Set the PDO error mode to exception
                                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                    // echo "Connected successfully";
                                } catch (PDOException $e) {
                                    echo "Connection failed: " . $e->getMessage();
                                }
                                // Insert new user
                                $id = rand(1, 999);
                                $name_quo = $conn->quote($name);
                                $email = $conn->quote($email);
                                $pwd = $conn->quote($pwd);
                                $rows = $conn->query("INSERT INTO students (id, name, email, password)
                                VALUES ($id, $name_quo, $email, $pwd)");
                                echo '<div style="text-align:center">';
                                echo "Welcome to HOTELES.COM, $name !";
                                echo '</div>';
                                // echo 'User added sucessfully';
                                ?>
                            </div>
                            <div style="margin-top:2rem">
                                <a href="cliente.php">
                                    <button type="button" class="btn btn-primary btn-block">Empezar a navegar</button>
                                </a> <!-- Botón para volver -->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>