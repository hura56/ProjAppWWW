<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = '164384';
$login = 'admin';
$pass = 'admin';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die('<b>Przerwane połączenie</b>: ' . mysqli_connect_error());
}
?>
