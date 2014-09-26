<?php echo '<?php'; ?> echo render('include/crud_title',array('item'=>$item,'uri'=>'<?php echo $uri; ?>', 'model'=>'<?php echo $singular_name; ?>', 'show'=>'V' )); <?php echo '?>';?>


<div class="form-horizontal">
<?php foreach ($fields as $field): ?>
	<div class="form-group">
		<label class="col-sm-2 control-label"><?php echo '<?php'; ?> echo __('model.<?php echo $singular_name; ?>.<?php echo $field['name']; ?>') <?php echo '?>'; ?></label>
		<div class="col-sm-10">
			<p class="form-control"><?php echo '<?php'; ?> echo $item-><?php echo $field['name']; ?>; <?php echo '?>'; ?></p>
		</div>
	</div>
<?php endforeach; ?>
</div>

<?php echo '<?php'; ?> echo render('include/crud_pager',array('item'=>$item,'uri'=>'<?php echo $uri; ?>','show'=>'LE' )); <?php echo '?>';?>
