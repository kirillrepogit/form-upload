<?php foreach($images as $image){?>

<div class="imageWrapper">
	<?php $file = 'app/controller/uploads/'.$image['name'];?>
	<img src="<?=$file?>">
	<p><?=$image['size']?></p>
</div>

<?php }?>