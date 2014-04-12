<h2><?php echo '<?php echo'; ?> __('trait-crud.message.Viewing_MODEL_NUM', array('model'=>'<?php echo \Str::ucfirst($singular_name); ?>','id'=>$item->id)) <?php echo '?>'; ?></h2>

<?php foreach ($fields as $field): ?>
<p>
	<strong><?php echo '<?php'; ?> echo __('model.<?php echo $singular_name; ?>.<?php echo $field['name']; ?>') <?php echo '?>'; ?>:</strong>
	<?php echo '<?php'; ?> echo $item-><?php echo $field['name']; ?>; <?php echo '?>'; ?>
</p>
<?php endforeach; ?>

<?php echo '<?php'; ?> echo Html::anchor('<?php echo $uri ?>/edit/'.$item->id, __('trait-crud.button.Edit')); <?php echo '?>'; ?> |
<?php echo '<?php'; ?> echo Html::anchor('<?php echo $uri ?>', __('trait-crud.button.Back')); <?php echo '?>'; ?>
