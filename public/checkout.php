<?php
session_start();

require_once('../includes/db_functions.php');
require_once('../includes/functions.php');
require_once('../templates/header.php');

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    redirect_to('index.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'checkout') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    
    $nameSplChars = array('!', '@', '#', '$', '%', '^', '&', '*', '<', '>', '/', '?', '(', ')', '=', '|', '+', '-', "'", '"', '~', '`', ':', ';', '[', ']', '{', '}', '_', '\\');

    $name = str_replace($splChars, '', $name);
    $address = str_replace($splChars, '', $address);
    $email = str_replace($splChars, '', $email);
 	

    if (empty($name) || empty($address) || empty($email)) {
        $error = "All fields are required.";
    } else {
        $conn = db_connect();

        // Calculate total amount from the items in the cart
        $totalAmount = 0;
        foreach ($_SESSION['cart'] as $book) {
            $totalAmount += $book['price'] * $book['quantity'];
        }

        // Insert order details into the database
        $query = "INSERT INTO orders (name, address, email, total_amount) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssd", $name, $address, $email, $totalAmount);
        $success = mysqli_stmt_execute($stmt);

        if ($success) {
            // Process checkout
            unset($_SESSION['cart']);
            $successMessage = "Thank you for your purchase!";
        } else {
            $errorMessage = "Error processing your order. Please try again later.";
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
?>

<!-- HTML code for checkout form -->

<?php
require_once('../templates/footer.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookstore - Checkout</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header class="bg-dark text-white text-center py-4">
    <h1 class="display-4">Checkout</h1>
</header>

<main class="container my-4">
    <form method="post">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <textarea id="address" name="address" class="form-control" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <?php if (isset($error)) : ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (isset($success)) : ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php endif; ?>

        <input type="hidden" name="action" value="checkout">
        <button type="submit" class="btn btn-primary">Checkout</button>
    </form>
</main>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
