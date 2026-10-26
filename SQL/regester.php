
<?php

try {
    $db = new PDO("mysql:host=localhost;dbname=mon-in", "root", "");
} catch (PDOException $e) {
    die("Error" . $e->getMessage());
}


$fullname = "";
$email = "";
$password = "";
$confirm_password = "";
$error = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password !== $confirm_password) {
        $error = "Wachtwoord en bevestiging komen niet overeen.";
    } else {

        $hashedPassword = $password;

        $sql = "INSERT INTO users (name, email, password)
    VALUES (:name, :email, :password)";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(":name", $fullname);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->execute();

        header('Location: index.php');
        exit;
    }
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
          <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Account
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="user.php?profile=<?php echo $id; ?>">Profiel</a></li>
            <li><a class="dropdown-item" href="#">Instellingen</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="regester.php">Registreren</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>


<div class="container vh-100 d-flex justify-content-center align-items-center">
    
    <div class="card p-4 shadow" style="width: 400px;">
        
        <h3 class="text-center mb-4">Registreren</h3>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="text" class="form-label">Gebruikersnaam</label>
                <input type="text" class="form-control" id="text" placeholder="Jan1234" required name="fullname"
                value="<?php echo htmlspecialchars($fullname)?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" placeholder="email@example.com" required name="email"
                value="<?php echo htmlspecialchars($email)?>">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Wachtwoord</label>
                <input type="password" class="form-control" id="password" required name="password">
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Bevestig wachtwoord</label>
                <input type="password" class="form-control" id="confirm_password" required name="confirm_password">
            </div>

            <button type="submit" class="btn btn-primary w-100">Registreren</button>
            <a href="index.php" class="btn">Homepage</a>
        </form>

    </div>

</div>











<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>




    
</body>
</html>