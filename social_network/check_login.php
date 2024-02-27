<?php
session_start();
require_once './connect_db.php';
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {
    header('Location: login.php');
}
