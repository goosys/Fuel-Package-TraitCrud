<h2><?php echo '<?php echo'; ?> __('trait-crud.message.Listing_MODEL', array('model'=>'<?php echo \Str::ucfirst($plural_name); ?>')) <?php echo '?>'; ?></h2>
<br>
<?php echo "<?php if (\$items): ?>"; ?>

<table class="table table-striped">
	<thead>
		<tr>
			<th style="width:3em;"><br></th>
<?php foreach ($fields as $field): ?>
			<th><?php echo "<?php echo __('model.{$singular_name}.{$field['name']}'); ?>"; ?></th>
<?php endforeach; ?>
			<th style="width:10em;"><br></th>
		</tr>
	</thead>
	<tbody>
<?php echo '<?php'; ?> foreach ($items as $item): <?php echo '?>'; ?>
		<tr>
			<th><?php echo '<?php'; ?> echo $item->id; <?php echo '?>'; ?></th>

<?php foreach ($fields as $field): ?>
			<td><?php echo '<?php'; ?> echo $item<?php echo '->'.$field['name']; ?>; <?php echo '?>'; ?></td>
<?php endforeach; ?>
			<td>
				
			</td>
		</tr>
<?php echo '<?php endforeach; ?>'; ?>
	</tbody>
</table>

<?php echo '<?php '; ?>if( isset($pagination) && $pagination ){ echo $pagination; }<?php echo '?>'; ?>

<?php echo '<?php else: ?>'; ?>

<p><?php echo '<?php echo'; ?> __('trait-crud.message.No_MODEL', array('model'=>'<?php echo \Str::ucfirst($plural_name); ?>')) <?php echo '?>'; ?></p>

<?php echo '<?php endif; ?>'; ?>
<p>
	<?php echo '<?php'; ?> echo Html::anchor('<?php echo $uri; ?>/create', __('trait-crud.button.Add_new_MODEL', array('model'=>'<?php echo \Inflector::humanize($singular_name); ?>')), array('class' => 'btn btn-success')); <?php echo '?>'; ?>


</p>
