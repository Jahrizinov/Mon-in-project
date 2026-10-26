<?php
try {
    $db = new PDO("mysql:host=localhost;dbname=mon-in", "root", "");
} catch (PDOException $e) {
    die("Error" . $e->getMessage());
}

$profile = null;
$id = isset($_GET["profile"]) ? (int) $_GET["profile"] : 0;

if ($id > 0) {
    $sql = $db->prepare("SELECT * FROM users WHERE id = ?");
    $sql->execute([$id]);
    $profile = $sql->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<title>Profile</title>
</head>

<body class="bg-light">


<?php
function getUser($id, $db)
{
    $sql = $db->prepare("SELECT * FROM users WHERE id = ?");
    $sql->execute([$id]);
    return $sql->fetch(PDO::FETCH_ASSOC);
}

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
}

$query = $db->prepare("SELECT * FROM posts WHERE user_id = ?");
$query->execute([$id]);
$posts = $query->fetchAll(PDO::FETCH_ASSOC);
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
            <li><a class="dropdown-item" href="#">Uitloggen</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">

    <div class="card shadow-lg border-0 mx-auto" style="max-width:1000px;">
        <div class="card-body text-center p-4 w-100">

            <img src="<?= $profile['avatar']; ?>" 
            class="rounded-circle mb-3 border border-3 border-light shadow"
            style="width:150px; height:150px; object-fit:cover;">

            <h3 class="fw-bold"><?= $profile['name']; ?></h3>

            <p class="text-muted fs-5"><?= $profile['headline']; ?></p>

            <hr>




        </div>
    </div>


<div class="card shadow border-0 mb-4 mt-4">
<div class="card-body">

<h4 class="mb-3">Skills</h4>

<?php
$skills = explode(",", $profile['skills']);
foreach($skills as $skill){
?>
<span class="badge bg-info text-dark me-2 mb-2 p-2">
<?= trim($skill); ?>
</span>
<?php } ?>
<br>
<hr>
<br>
<h4 class="mb-3">Interests</h4>

<?php
$interests = explode(",", $profile['interests']);
foreach($interests as $interest){
?>
<span class="badge bg-info text-dark me-2 mb-2 p-2">
<?= trim($interest); ?>
</span>
<?php } ?>


<div class="container mt-5">

    <div class="card shadow-lg border-0 mx-auto" style="max-width:1000px;">
        <div class="card-body text-center p-4 w-100">
<h4 class="mt-5 mb-3">Posts</h4>

<?php foreach($posts as $post): ?>

<div class="card shadow mb-3">
<div class="card-body">

<p class="card-text">
<?= $post['content']; ?>
</p>

<small class="text-muted">
<?= timeAgo($post['created_at']); ?>
</small>

</div>
</div>

<?php endforeach; ?>



        </div>
    </div>

<div class="container mt-5">

    <div class="card shadow-lg border-0 mx-auto" style="max-width:1000px;">
        <div class="card-body text-center p-4 w-100">


            <a href="index.php" class="btn btn-info text-white px-4">
                Back to feed
            </a>

        </div>
    </div>





</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>
</html>