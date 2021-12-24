<?php
session_start();
$user = 'root';
$pswd = '';
$pdo = new PDO('mysql:dbname=fullstack;host=127.0.0.1', $user, $pswd);
$pdo->query("SET NAMES 'utf8'");