<?php
try {
    $db = new PDO("mysql:host=localhost;dbname=mon-in", "root", "");
} catch (PDOException $e) {
    die("Error" . $e->getMessage());
}

function getUser($id, $db)
{
    $sql = $db->prepare("SELECT * FROM users WHERE id = ?");
    $sql->execute([$id]);
    return $sql->fetch(PDO::FETCH_ASSOC);
}

$profile = null;

if (isset($_GET['profile'])) {
    $id = (int) $_GET['profile'];
    $profile = getUser($id, $db);
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>

<body>
    <?php

    $query = $db->prepare("SELECT * FROM posts");
    $query->execute();
    $posts = $query->fetchAll(PDO::FETCH_ASSOC);

    function timeAgo($datetime): string
    {
        $time = new DateTime($datetime);
        $now = new DateTime();
        $diff = $now->diff($time);

        if ($diff->y > 0) {
            $s = ($diff->y == 1) ? "" : "s";
            return $diff->y . " year$s ago";
        }

        if ($diff->m > 0) {
            $s = ($diff->m == 1) ? "" : "s";
            return $diff->m . " month$s ago";
        }

        if ($diff->d > 0) {
            $s = ($diff->d == 1) ? "" : "s";
            return $diff->d . " day$s ago";
        }

        if ($diff->h > 0) {
            $s = ($diff->h == 1) ? "" : "s";
            return $diff->h . " hour$s ago";
        }

        if ($diff->i > 0) {
            $s = ($diff->i == 1) ? "" : "s";
            return $diff->i . " minute$s ago";
        }

        return "just now";
    };


    ?>

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
            <li><a class="dropdown-item" href="regester.php">Regesteren</a></li>
            <li><a class="dropdown-item" href="login.php">Login</a></li>
            <li><a class="dropdown-item" href="logout.php">uitloggen</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

    <div class="container mt-4">
        <h2 class="d-flex justify-content-center">Recent Posts</h2>



<?php if($profile): ?>
<div class="card mb-4 border shadow-sm w-50 mx-auto text-center">
    <div class="card-body">

        <!-- Avatar gecentreerd -->
        <img src="<?= $profile['avatar']; ?>" class="rounded-circle mb-3 w-50">

        <h3><?= $profile['name']; ?></h3>
        <p class="text-secondary"><?= $profile['headline']; ?></p>

        <!-- Eventueel: knop om terug naar homepage/posts -->
        <a href="index.php" class="btn btn-sm btn-primary mt-2">Terug</a>

    </div>
</div>
<?php endif; ?>



<?php foreach ($posts as $post):
    $user = getUser($post['user_id'], $db); ?>

    <div class="card mb-3 border border-2 shadow-sm w-75 mx-auto">
        <div class="card-body m-4 ">

            <h5 class="card-title pb-3 text-center">
                <a href="user.php?profile=<?= $user['id'] ?>" class="text-decoration-none text-dark text-center">
                    <?= $user['name']; ?>
                </a>
            </h5>

            <a href="user.php?profile=<?= $user['id'] ?>" class="text-decoration-none text-dark d-flex justify-content-center">
                <img src="<?= $user['avatar']; ?>" class="w-25 rounded-circle mb-2 text-center">
            </a>

            <p class="text-secondary text-center">
                <?= $user['headline']; ?>
            </p>

            <p class="card-text">
                <?= $post['content']; ?>
            </p>

            <p class="card-time">
                <?= timeAgo($post['created_at']); ?>
            </p>
        </div>
    </div>

<?php endforeach ?>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>