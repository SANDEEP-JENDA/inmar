<?php
session_start();
require_once('functions.php');
generate_csrf_token();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookstore - Home</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header class="bg-dark text-white text-center py-4">
    <h1 class="display-4">Bookstore</h1>
</header>

<main class="container my-4">
    <h2 class="mb-4">Books</h2>
    <div class="table-responsive">
        <!-- Book listing table -->
    </div>
</main>

<footer class="bg-dark text-white text-center py-4">
    <a href="view_cart.php" class="btn btn-secondary">View Cart</a>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
