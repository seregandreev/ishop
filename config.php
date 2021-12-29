<?php
define('PRODUCTS_IMAGE_PATH', '/images/products/');

session_start();
$user = 'root';
$pswd = '';
$pdo = new PDO('mysql:dbname=fullstack;host=127.0.0.1', $user, $pswd);
$pdo->query("SET NAMES 'utf8'");

$ducument_root = $_SERVER['DOCUMENT_ROOT'];