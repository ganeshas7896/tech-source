<?php $page='automation';$title='Automation Testing';include 'header.php';$t=array_reverse(rows('at_topics'));$s=$pdo->query("SELECT * FROM sources WHERE category LIKE '%Automation%'")->fetchAll();?>
<section class="wrap"><h1>Automation Testing</h1><p class="lead">Our learning path: what we study, what we learn, how long it takes, and where from.</p>
<div class="timeline"><?php foreach($t as $x):?><article class="card"><span class="time"><?=e($x['duration'])?></span><h3><?=e($x['title'])?></h3>
<p><b>Details:</b> <?=e($x['details'])?></p><p><b>Learnings:</b> <?=e($x['learnings'])?></p></article><?php endforeach;?></div>
<h2>Sources</h2><ul class="list"><?php foreach($s as $r):?><li><a target="_blank" rel="noopener" href="<?=e($r['link'])?>"><?=e($r['title'])?></a> – <?=e($r['note'])?></li><?php endforeach;?></ul>
<p>Need help? Ask the AI Learning Agent at the bottom right about testing or any other technology.</p></section>
<?php include 'footer.php';?>
