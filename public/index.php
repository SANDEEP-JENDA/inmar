<?php
session_start(); // Start the session

require_once('../includes/db_functions.php');
require_once('../includes/functions.php');
require_once('../templates/header.php');

$conn = db_connect();
$result = mysqli_query($conn, "SELECT * FROM books");

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Add to cart functionality
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add_to_cart') {
    $book_id = filter_input(INPUT_POST, 'book_id', FILTER_SANITIZE_NUMBER_INT);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);
    
    $SplChars = array('!', '@', '#', '$', '%', '^', '&', '*', '<', '>', '/', '?', '(', ')', '=', '|', '+', '-', "'", '"', '~', '`', ':', ';', '[', ']', '{', '}', '_', '\\');
    $book_id = str_replace($splChars, '', $book_id);
    $quantity = str_replace($splChars, '', $quantity);
    
    $result = mysqli_query($conn, "SELECT * FROM books WHERE id='$book_id'");
    $book = mysqli_fetch_assoc($result);
    if ($book) {
        $book['quantity'] = $quantity;
        $_SESSION['cart'][] = $book;
    }
}
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
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['author']) . "</td>";
                        echo "<td>{$row['price']}</td>";
                        echo "<td><input type='number' name='quantity' value='1' min='1'></td>";
                        echo "<td>";
                        echo "<form method='post'>";
                        echo "<input type='hidden' name='book_id' value='{$row['id']}'>";
                        echo "<input type='hidden' name='action' value='add_to_cart'>";
                        echo "<button type='submit' class='btn btn-primary'>Add to Cart</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No books found</td></tr>";
                }
                ?>
            </tbody>
        </table>
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
