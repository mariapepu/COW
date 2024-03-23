<!doctype html>
<html lang="en">

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


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>
<link href="styles_server.css" rel="stylesheet">
</head>

<?php
function check_dates($d1, $d2)
{
    return (strtotime($d2) > strtotime($d1) && strtotime($d1) >= strtotime(date("Y/m/d")));
}
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $dest = htmlspecialchars($_POST["destination"]);
        $checkin = $_POST["checkin"];
        $checkout = $_POST["checkout"];
        $guests = $_POST["guests"];
        $regex_dest = "/^[a-zA-Z -]{1,20}$/"; // Max: 20 characters
        $regex_guests = "/^[1-9]{1,2}$/"; // Max: 100 guests

        if (!preg_match($regex_dest, $dest)) {
            throw new Exception('Destination field must contain 1 to 20 characters!');
        } elseif (!preg_match($regex_guests, $guests)) {
            throw new Exception('Guests number must be between 1 and 20!');
        } elseif (!check_dates($checkin, $checkout)) {
            throw new Exception('Checkin date must be greater or equal than today!');
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
    $conn = new PDO("mysql:host=$servername;dbname=world", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
    // echo '<h5>Filters: ' . $checkin . '-' . $checkout . ' for ' . $guests . ' guests</h5>';
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
$dest = $conn->quote($dest);
$rows = $conn->query("SELECT * FROM cities WHERE name = $dest");
?>

<body>
    <div class="bs-canvas-overlay bs-canvas-anim bg-dark position-fixed w-100 h-100">
    </div>

    <!-- contenido que debe ser empujado por la nav bar -->
    <div class="bs-offset-main bs-canvas-anim">
        <!-- barra superior -->
        <nav class="navbar">
            <button class="btn" type="button" data-toggle="canvas" data-target="#bs-canvas-left" aria-expanded="false"
                aria-controls="bs-canvas-left">&#9776;</button>
            <div>
                <img src="../assets\logo_simple.webp" alt="logo" width="30" height="30">
                <h5 class="d-inline-block align-text-top">HOTELES.COM</h5>
            </div>
            <div class="dropdown">
                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                    <img src="../assets\icons\account_circle.svg" alt="sesion">
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="sign_up.php">Sign Up</a>
                    <a class="dropdown-item disabled" href="#">Sign In</a>
                </div>
            </div>
        </nav>

        <main role="main">
            <section class="jumbotron text-center">
                <div class="container">
                    <h1 class="jumbotron-heading section-title">Tu búsqueda</h1>
                    <form action="./servidor.php" method="POST" class="form-inline justify-content-center">
                        <div class="input-group mb-2">
                            <input type="text" class="form-control"
                                placeholder="Introduce una ciudad, pueblo o lugar de interés" name="destination"
                                value=<?php echo $dest ?> required>
                        </div>
                        <input type="date" class="form-control mb-2" name="checkin" value=<?php echo $checkin ?>>
                        <input type="date" class="form-control mb-2" name="checkout" value=<?php echo $checkout ?>>
                        <div class="input-group mb-2">
                            <select id="inputState" class="form-control" name="guests">
                                <option selected>
                                    <?php echo $guests ?>
                                </option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                            </select>
                        </div>
                        <button type="submit" class="btn search-button btn-lg mb-2">
                            <img src="../assets/icons/search.svg" class="icon" alt="Buscar">
                        </button>
                    </form>
                </div>
            </section>

            <!-- cards -->
            <div class="album py-5">
                <div class="section-title">
                    <h1>Resultados</h1>
                </div>
                <?php
                if ($rows->rowCount() > 0) {
                    echo '<div class="container">';
                    echo '<div class="row">';

                    foreach ($rows as $row) {
                        echo '<div class="col-md-4 mb-4">'; 
                        echo '<div class="card mx-auto" style="width: 18rem;">';
                        // si nay img añadila
                        // echo '<img src="../path_to_image/'.$row['image'].'" class="card-img-top" alt="'.$row['name'].'">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $row['name'] . '</h5>'; 
                        echo '<p class="card-text">' . $row['district'] . '</p>';
                        echo '<p class="card-text">Country: ' . $row['country_code'] . '</p>'; 
                        echo '<p class="card-text">Population: ' . $row['population'] . '</p>'; 
                        echo '</div>';
                        echo '</div>'; 
                        echo '</div>';
                    }

                    echo '</div>';
                    echo '</div>'; 
                } else {
                    echo 'No destinations were found. Please, try another destination!';
                }
                ?>
            </div>
        </main>
    </div>

    <!-- Off-canvas sidebar markup, left/right or both. -->
    <div id="bs-canvas-left" class="bs-canvas bs-canvas-anim bs-canvas-left position-fixed h-100" data-offset="true"
        data-overlay="false">
        <header class="bs-canvas-header p-3">
            <h4 class="d-inline-block mb-0">Menú</h4>
            <button type="button" class="bs-canvas-close close" aria-label="Close"><span aria-hidden="true"
                    class="text-dark">&times;</span></button>
        </header>
        <div class="bs-canvas-content px-3 py-5">
        </div>
        <!-- inside nav bar -->
        <div class="collapse bg-dark" id="navbarHeader"></div>
        <div class="bs-canvas-content px-3 py-5">
            <div class="list-group my-5">
                <h3 class="h3-menu">Inicio de session</h3>
                <hr class="menu-hr">
                <h3 class="h3-menu">Explorar</h3>
                <h3 class="h3-menu">Escribenos</h3>
                <h3 class="h3-menu">Cookies</h3>
                <hr class="menu-hr">
                <h3 class="h3-menu">Filtros</h3>
                <ul class="menu-ul">
                    <li class="menu-li">Estrellas</li>
                    <li class="menu-li">Precio</li>
                    <li class="menu-li">Valoración de usuarios</li>
                    <li class="menu-li">Ubicación</li>
                    <li class="menu-li">Tipo de alojamiento</li>
                    <li class="menu-li">Facilidades</li>
                    <li class="menu-li">Disponibilidad</li>
                </ul>
            </div>
        </div>
    </div>

    <footer class="text-muted">
        <div class="container">
            <div class="row">
                <p class="col-md-4">
                    <img src="../assets/logo_simple.webp" alt="Logo hoteles.com" class="footer-logo">
                </p>
                <div class="col-md-4" style="text-align: center;">
                    <p><a href="/sobre-nosotros">Sobre nosotros</a></p>
                    <p><a href="/contacto">Contacto</a></p>
                    <p><a href="/terminos-y-condiciones">Términos y Condiciones</a></p>
                    <p><a href="/politica-de-privacidad">Política de Privacidad</a></p>
                </div>
                <div class="col-md-4" style="text-align: center;">
                    <a href="https://www.facebook.com/" target="_blank">
                        <img src="../assets/icons/facebook.svg" alt="Facebook" />
                    </a>
                    <a href="https://www.twitter.com/" target="_blank">
                        <img src="../assets/icons/twitter.svg" alt="Twitter" />
                    </a>
                    <a href="https://www.instagram.com/" target="_blank">
                        <img src="../assets/icons/instagram.svg" alt="Instagram" />
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p class="footer-copy">&copy; 2024 Hoteles.com. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
        </div>
    </footer>

</body>

</html>