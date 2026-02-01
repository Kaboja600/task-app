<?php
$conn = new mysqli("localhost", "root", "", "task_app");
if ($conn->connect_error) {
    die("Database failed");
}
session_start();
?>