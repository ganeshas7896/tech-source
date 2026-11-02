<?php require 'config.php';
$T=['products'=>['title','description','url','tech'],'features'=>['title','description'],'sources'=>['title','link','category','note'],'at_topics'=>['title','details','learnings','duration']];
if(isset($_GET['out'])){session_destroy();header('Location: admin.php');exit;}
if(isset($_POST['pass'])&&hash_equals(ADMIN_PASS,$_POST['pass'])){$_SESSION['a']=1;}
$in=!empty($_SESSION['a']);
if($in&&$_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['t'],$T[$_POST['t']])){$t=$_POST['t'];
 if(isset($_POST['del']))$pdo->prepare("DELETE FROM `$t` WHERE id=?")->execute([(int)$_POST['del']]);
 elseif(isset($_POST['id'])&&(int)$_POST['id']>0){$c=$T[$t];$set=implode(',',array_map(fn($k)=>"`$k`=?", $c));$values=array_map(fn($k)=>trim($_POST[$k]??''),$c);$values[]=(int)$_POST['id'];$pdo->prepare("UPDATE `$t` SET $set WHERE id=?")->execute($values);}
 else{$c=$T[$t];$pdo->prepare("INSERT INTO `$t`(".implode(',',$c).") VALUES(".implode(',',array_fill(0,count($c),'?')).")")->execute(array_map(fn($k)=>trim($_POST[$k]??''),$c));}
 header('Location: admin.php#'.$t);exit;}
$page='admin';$title='Admin';include 'header.php';?>
<section class="wrap"><h1>Admin</h1>
<?php if(!$in):?><form method="post" class="form narrow"><input type="password" name="pass" placeholder="Admin password" required><button class="btn">Log in</button></form>
<?php else:?><p><a class="btn ghost admin-logout" href="?out=1">Log out</a></p>
<?php foreach($T as $t=>$cols):?><h2 id="<?=$t?>"><?=ucfirst(str_replace('_',' ',$t))?></h2>
<form method="post" class="form"><input type="hidden" name="t" value="<?=$t?>">
<?php foreach($cols as $c):?><<?=in_array($c,['description','details','learnings','note'])?'textarea rows="2"':'input'?> name="<?=$c?>" placeholder="<?=$c?>" required></<?=in_array($c,['description','details','learnings','note'])?'textarea':'input'?>><?php endforeach;?>
<button class="btn sm">Add</button></form>
<div class="admin-items"><?php foreach(rows($t) as $r):?><article class="card admin-item"><div class="admin-item-heading"><b><?=e($r['title'])?></b>
<form method="post"><input type="hidden" name="t" value="<?=$t?>"><button name="del" value="<?=$r['id']?>" class="btn sm danger" onclick="return confirm('Delete this item?')">Delete</button></form></div>
<details class="admin-edit"><summary class="btn sm ghost">Edit</summary><form method="post" class="form admin-edit-form"><input type="hidden" name="t" value="<?=$t?>"><input type="hidden" name="id" value="<?=$r['id']?>">
<?php foreach($cols as $c):?><?php if(in_array($c,['description','details','learnings','note'])):?><label><?=e(ucfirst($c))?><textarea name="<?=$c?>" rows="3" required><?=e($r[$c])?></textarea></label>
<?php else:?><label><?=e(ucfirst($c))?><input name="<?=$c?>" value="<?=e($r[$c])?>" required></label><?php endif;?><?php endforeach;?>
<button class="btn sm" type="submit">Save changes</button></form></details></article><?php endforeach;?></div>
<?php endforeach;?>
<h2>Messages</h2><?php foreach(rows('messages') as $m):?><article class="card"><b><?=e($m['name'])?></b> &lt;<?=e($m['email'])?>&gt;<p><?=e($m['message'])?></p></article><?php endforeach;?>
<h2 id="feedback">Feedback</h2><?php foreach(rows('feedback') as $f):?><article class="card"><b><?=e($f['name']?:'Anonymous')?></b> · <?=e($f['rating'])?>/5 <small><?=e($f['created_at'])?></small><p><?=e($f['feedback'])?></p></article><?php endforeach;?>
<?php endif;?></section><?php include 'footer.php';?>
