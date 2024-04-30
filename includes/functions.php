<?php
function redirect_to($location) {
    header("Location: " . $location);
    exit;
}

function sanitize_input($input) {
    return htmlspecialchars(strip_tags($input));
}
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}

function validate_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
?>
