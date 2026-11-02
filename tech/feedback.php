<?php
$page='feedback';
$title='Feedback';
include 'header.php';
$ok='';
$err='';
$rating='';
$feedback='';

if($_SERVER['REQUEST_METHOD']==='POST'){
 $rating=filter_var($_POST['rating']??null,FILTER_VALIDATE_INT);
 $feedback=trim($_POST['feedback']??'');

 if($rating===false||$rating<1||$rating>5){
  $err='Choose a rating from 1 to 5.';
 }elseif($feedback===''||strlen($feedback)>2000){
  $err='Feedback is required and must be 2,000 characters or fewer.';
 }else{
  $pdo->prepare('INSERT INTO feedback(name,rating,feedback) VALUES(?,?,?)')
      ->execute([null,$rating,$feedback]);
  $ok='Thank you for sharing your feedback!';
  $rating='';
  $feedback='';
 }
}
?>
<section class="wrap narrow">
<h1>Share your feedback</h1>
<p class="lead">Tell us what you think about Tech Source, our website, or what you would like us to improve.</p>
<p class="privacy-note">Your feedback is anonymous. Only the site administrator can review submissions.</p>
<?php if($ok):?><p class="alert ok"><?=e($ok)?></p><?php endif;?>
<?php if($err):?><p class="alert bad"><?=e($err)?></p><?php endif;?>
<form method="post" class="form">
<fieldset class="rating-field"><legend>Your rating</legend><div class="rating-options">
<?php foreach([5=>'Excellent',4=>'Good',3=>'Okay',2=>'Needs work',1=>'Poor'] as $value=>$label):?>
<label class="rating-option"><input type="radio" name="rating" value="<?=$value?>" required <?=$rating===$value?'checked':''?>>
<span class="rating-stars" aria-hidden="true"><?=str_repeat('★',$value)?></span><span><?=e($label)?></span></label>
<?php endforeach;?>
</div></fieldset>
<label for="feedback-message">Your feedback</label>
<textarea id="feedback-message" name="feedback" rows="6" maxlength="2000" required><?=e($feedback)?></textarea>
<button class="btn" type="submit">Send feedback</button>
</form>
</section>
<?php include 'footer.php';?>
