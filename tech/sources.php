<?php $page='sources';$title='Sources';include 'header.php';?>
<section class="wrap"><h1>Sources</h1><p class="lead">Links and notes we use. Added manually from the Admin panel.</p>
<div class="grid"><?php foreach(rows('sources') as $r):?><article class="card"><small><?=e($r['category'])?></small><h3><?=e($r['title'])?></h3><p><?=e($r['note'])?></p>
<a class="btn sm" target="_blank" rel="noopener" href="<?=e($r['link'])?>">Open</a></article><?php endforeach;?></div></section>
<?php include 'footer.php';?>
