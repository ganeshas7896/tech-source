<?php $page='index';$title='Home';include 'header.php';$websites=rows('products');?>
<section class="hero"><div><h1>Websites built right, tested before they ship.</h1>
<p>Tech Source designs and builds company websites, and automates the testing behind them.</p>
<a class="btn" href="products.php">See our websites</a> <a class="btn ghost" href="contact.php">Mail us</a></div>
<img class="float" src="logo.png" alt="Tech Source"></section>
<section class="wrap"><h2>What you get</h2><div class="grid">
<?php foreach(array_reverse(rows('features')) as $f):?><article class="card"><h3><?=e($f['title'])?></h3><p><?=e($f['description'])?></p></article><?php endforeach;?></div></section>
<section class="wrap"><div class="section-heading"><h2>Latest websites</h2><a class="btn ghost sm" href="products.php">View all websites</a></div>
<div class="website-scroll" aria-label="All websites">
<?php foreach($websites as $p):?><article class="card website-card"><h3><?=e($p['title'])?></h3>
<?php if($p['url']&&$p['url']!='#'):?><a class="btn sm" target="_blank" rel="noopener" href="<?=e($p['url'])?>">View site</a>
<?php else:?><span class="btn sm disabled" aria-disabled="true">View site</span><?php endif;?></article><?php endforeach;?>
</div></section>
<?php include 'footer.php';?>
