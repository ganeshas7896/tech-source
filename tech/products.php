<?php $page='products';$title='Websites';include 'header.php';$all=rows('products');?>
<section class="wrap"><h1>Our websites</h1><p class="lead">Added one by one from the Admin panel.</p>
<div class="grid"><?php foreach($all as $p):?><article class="card website-card product-card"><h3><?=e($p['title'])?></h3><p class="product-description" tabindex="0"><?=e($p['description'])?></p><small><?=e($p['tech'])?></small>
<?php if($p['url']&&$p['url']!='#'):?><a class="btn sm" target="_blank" rel="noopener" href="<?=e($p['url'])?>">Visit site</a><?php endif;?></article><?php endforeach;?></div></section>
<?php include 'footer.php';?>
