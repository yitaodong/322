<?php
/* Database connection settings */
$host = 'localhost';
$user = 'veggiebirds_player2';
$pass = 'veggiebirds2';
$db = 'veggiebirds_users';
$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);
