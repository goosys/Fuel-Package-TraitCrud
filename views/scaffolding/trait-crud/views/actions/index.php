<?php echo '<?php'; ?> echo render('include/crud_title',array('items'=>$items,'uri'=>'<?php echo $uri; ?>', 'model'=>'<?php echo $singular_name; ?>', 'show'=>'L' )); <?php echo '?>';?>



<table class="table table-striped">
	<thead>
		<tr>
			<th style="width:3em;"><br></th>
<?php $cnt=0; foreach ($fields as $field): ?>
			<th><?php echo "<?php echo __('model.{$singular_name}.{$field['name']}'); ?>"; ?></th>
<?php $cnt++; endforeach; ?>
			<th class="text-right">
				<?php echo '<?php'; ?> echo Html::anchor('<?php echo $uri; ?>/create', __('trait-crud.button.Add_new_MODEL', array('model'=>__('model.<?php echo $singular_name; ?>._name'))), array('class' => 'btn btn-success')); <?php echo '?>'; ?>
			</th>
		</tr>
	</thead>
<?php echo "<?php if (\$items): ?>"; ?>
	<tbody>
<?php echo '<?php'; ?> foreach ($items as $item): <?php echo '?>'; ?>
		<tr>
			<th class="text-right"><?php echo '<?php'; ?> echo $item->id; <?php echo '?>'; ?></th>

<?php foreach ($fields as $field): ?>
			<td><?php echo '<?php'; ?> echo $item<?php echo '->'.$field['name']; ?>; <?php echo '?>'; ?></td>
<?php endforeach; ?>
			<td class="text-right">
				<?php echo '<?php'; ?> echo render('include/list_btn',array('item'=>$item,'uri'=>'<?php echo $uri; ?>','layout'=>\Arr::get(array('text','icon','button'),2),'show'=>'VED' )); <?php echo '?>';?>
			</td>
		</tr>
<?php echo '<?php endforeach; ?>'; ?>
	</tbody>
<?php echo '<?php else: ?>'; ?>
	<tbody>
<tr><td><br></td><td colspan="<?php echo count($fields)+1; ?>"><?php echo '<?php echo'; ?> __('trait-crud.message.No_MODEL', array('model'=>__('model.<?php echo $singular_name; ?>._name'))) <?php echo '?>'; ?></td></tr>
	</tbody>
<?php echo '<?php endif; ?>'; ?>
</table>

<?php echo '<?php '; ?>if( isset($pagination) && $pagination ){ echo $pagination; }<?php echo '?>'; ?>


