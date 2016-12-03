<?php
$page = $_SERVER['REQUEST_URI'];
$errorMsg = "You are not authorized to access the page '".$page."'.";
echo "<h2>403 Error</h2>";
echo "<h3>$errorMsg</h3>";
?>