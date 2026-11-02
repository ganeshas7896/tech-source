<?php require_once __DIR__.'/config.php';
$nav=['index'=>'Home','about'=>'About','products'=>'Websites','automation'=>'Automation Testing','cyber-security'=>'Cyber Security','sources'=>'Sources','feedback'=>'Feedback','contact'=>'Contact'];?>
<!DOCTYPE html><html lang="en"><head><meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?=e($title??'Tech Source')?> | Tech Source</title>
<link rel="icon" href="logo.png">
<script>document.documentElement.dataset.theme=localStorage.getItem('theme')||'dark'</script>
<link rel="stylesheet" href="style.css"></head><body>
<header class="nav"><a class="brand" href="index.php"><img src="logo.png" alt="Tech Source logo"><b>Tech Source</b></a>
<button id="menu" aria-label="Menu">☰</button>
<nav id="links"><?php foreach($nav as $f=>$l):?><a href="<?=$f?>.php" class="<?=($page??'')==$f?'on':''?>"><?=$l?></a><?php endforeach;?>
<a class="admin-nav" href="admin.php">Admin Login</a>
<button id="theme" aria-label="Toggle theme">◐</button></nav></header><main>
