<?php
session_start(); // Start the session

require_once('../includes/functions.php');
require_once('../includes/db_functions.php');
require_once('../templates/header.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookstore - View Cart</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header class="bg-dark text-white text-center py-4">
    <h1 class="display-4">Shopping Cart</h1>
</header>

<main class="container my-4">
    <div class="table-responsive">
        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) : ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['cart'] as $book) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($book['title']); ?></td>
                            <td><?php echo htmlspecialchars($book['author']); ?></td>
                            <td><?php echo $book['price']; ?></td>
                            <td><?php echo $book['quantity']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>Your cart is empty</p>
        <?php endif; ?>
    </div>
</main>

<footer class="bg-dark text-white text-center py-4">
    <a href="index.php" class="btn btn-secondary">Continue Shopping</a>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
