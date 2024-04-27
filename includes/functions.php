<?php
function redirect_to($location) {
    header("Location: " . $location);
    exit;
}

function sanitize_input($input) {
    return htmlspecialchars(strip_tags($input));
}
?>
