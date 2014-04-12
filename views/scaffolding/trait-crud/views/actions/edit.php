<h2><?php echo '<?php echo'; ?> __('trait-crud.message.Editing_MODEL', array('model'=>'<?php echo \Str::ucfirst($singular_name); ?>')) <?php echo '?>'; ?></h2>
<br>

<?php echo '<?php'; ?> echo render('<?php echo $view_path; ?>/_form',$__data); ?>
<p>
	<?php echo '<?php'; ?> echo Html::anchor('<?php echo $uri; ?>/view/'.$item->id, __('trait-crud.button.View')); <?php echo '?>'; ?> |
	<?php echo '<?php'; ?> echo Html::anchor('<?php echo $uri; ?>', __('trait-crud.button.Back')); <?php echo '?>'; ?>
</p>
