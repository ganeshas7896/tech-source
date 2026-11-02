<?php
session_start();
const DB_HOST='sql210.infinityfree.com',DB_NAME='if0_43270119_techsource',DB_USER='if0_43270119',DB_PASS='techsource1234',ADMIN_PASS='Asg@6382367651';
$pdo=new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',DB_USER,DB_PASS,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);
function e($s){return htmlspecialchars((string)$s,ENT_QUOTES,'UTF-8');}
function rows($t){global $pdo;return $pdo->query("SELECT * FROM `$t` ORDER BY id DESC")->fetchAll();} // $t is always a hard-coded name
