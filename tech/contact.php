<?php $page='contact';$title='Contact';include 'header.php';$ok=$err='';
if($_SERVER['REQUEST_METHOD']=='POST'){
 $n=trim($_POST['name']??'');$m=trim($_POST['email']??'');$b=trim($_POST['message']??'');
 if(!$n||!filter_var($m,FILTER_VALIDATE_EMAIL)||!$b){$err='Enter your name, a valid email and a message.';}
 else{$pdo->prepare("INSERT INTO messages(name,email,message) VALUES(?,?,?)")->execute([$n,$m,$b]);
  $ok='Your message has been submitted for review.';}}?>
<section class="wrap narrow"><h1>Contact us</h1><p class="lead">Send us a message using the form below.</p>
<?php if($ok):?><p class="alert ok"><?=e($ok)?></p><?php endif;if($err):?><p class="alert bad"><?=e($err)?></p><?php endif;?>
<form method="post" class="form"><input name="name" placeholder="Your name" required><input name="email" type="email" placeholder="Your email" required>
<textarea name="message" rows="5" placeholder="Your message" required></textarea><button class="btn">Send message</button></form></section>
<?php include 'footer.php';?>
