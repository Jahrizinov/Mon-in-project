<?php


try {
  $db = new PDO("mysql:host=localhost;dbname=mon-in", "root", "");
} catch (PDOException $e) {
  die("Error" . $e->getMessage());
}

session_start();

if (!isset($_SESSION["user_id"])) {
  header("Location: login.php");

}


$sql = "
SELECT *
FROM users
WHERE id= :id";


$stmt = $db->prepare($sql);
$stmt->bindParam(":id", $_SESSION["user_id"]);
$stmt->execute();
$user = $stmt->fetch();




try {
    $db = new PDO("mysql:host=localhost;dbname=mon-in", "root", "");
} catch (PDOException $e) {
    die("Error" . $e->getMessage());
}





if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["floatingTextarea2"]) && !empty(trim($_POST["floatingTextarea2"]))) {
        $content = trim($_POST["floatingTextarea2"]);
        $user_id = $_SESSION["user_id"];
        
        $stmt = $db->prepare("INSERT INTO posts (content, user_id) VALUES (:content, :user_id)");
        $stmt->bindParam(":content", $content);
        $stmt->bindParam(":user_id", $user_id);
        
        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        } else {
            die("Error posting comment");
        }
    }
}













?>







<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <title>Document</title>
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
              <li><a class="dropdown-item" href="regester.php">Regesteren</a></li>
              <li><a class="dropdown-item" href="login.php">Login</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>





  <div class="container vh-100 d-flex justify-content-center align-items-center">

    <div class="card p-4 shadow" style="width: 400px;">

      <h3 class="text-center mb-4">Welkom <?php
      echo $user["name"]; ?></h3>

      <form method="POST" action="">

        <div class="mb-3">
          <label class="form-label">Post</label>
        </div>

        <div class="form-floating">
          <textarea class="form-control mb-2" placeholder="Leave a comment here" id="floatingTextarea2"
            name="floatingTextarea2" style="height: 100px"></textarea>
          <label for="floatingTextarea2">Comments</label>
        </div>


        <button type="submit" class="btn btn-primary w-100" value="Login">Post Comment</button>
        <a href="index.php" class="btn">Homepage</a>
      </form>

    </div>

  </div>










  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>

</body>

</html>