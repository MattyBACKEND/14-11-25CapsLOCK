<?php
session_start();
if (isset($_POST['code'])) {
    if ($_SESSION['verification_code'] == $_POST['code']) {
        echo "verified";
    } else {
        echo "invalid";
    }
}
?>