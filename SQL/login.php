<?php

session_start();

try {
    $db = new PDO("mysql:host=localhost;dbname=mon-in", "root", "");
} catch (PDOException $e) {
    die("Error" . $e->getMessage());
}


$email = "";
$password = "";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];


        $stmt = $db->prepare("SELECT id, email, password FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user==null) {
            die("E-mail of Wachtwoord is onjuist");

        }

        if ($password == $user["password"]) {
            $_SESSION["user_id"] = $user["id"];
            header("Location: home.php");
            exit;

        } else {
            die("E-mail of Wachtwoord is onjuist");
        
        };
}














?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Registreren</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-primary text-light">
        <div class="container-fluid">
            <a class="navbar-brand text-light" href="index.php">LinkedIn</a>
            <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarNavAltMarkup">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active text-light" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="user.php?profile=<?php echo $id; ?>">Profiel</a></li>
                            <li><a class="dropdown-item" href="#">Instellingen</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="regester.php">Registreren</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container vh-100 d-flex justify-content-center align-items-center">

        <div class="card p-4 shadow" style="width: 400px;">

            <h3 class="text-center mb-4">Login</h3>

            <form method="POST" action="">

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="email@example.com" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Wachtwoord</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary w-100" value="Login">Login</button>
                <a href="index.php" class="btn">Homepage</a>
            </form>

        </div>

    </div>











    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>





</body>

</html>