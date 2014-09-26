<?php echo '<?php $errors = Session::get_flash(\'error\')?: array(); ?>'; ?>
<?php echo '<?php $val    = Session::get_flash(\'validation\')?: array(); ?>'; ?>


<?php echo '<?php if( !isset($relation) || !$relation ): ?>' ?>

<?php echo '<?php echo Form::open(array("class"=>"","role"=>"form")); ?>' ?>

<?php foreach ($fields as $field): ?>

		<div class="form-group<?php echo '<?php echo ($errors && $val->error(\''.$field['name'].'\'))?" has-error":""; ?>';?>">
			<?php echo "<?php echo Form::label(__('model.{$singular_name}.{$field['name']}'), '{$field['name']}', array('class'=>'control-label')); ?>\n"; ?>

<?php switch($field['type']):

				case 'text':
					echo "\t\t\t<?php echo Form::textarea('{$field['name']}', Input::post('{$field['name']}', isset(\$item) ? \$item->{$field['name']} : ''), ".
						"array('class' => 'form-control', 'rows' => 8, 'placeholder'=>'".\Inflector::humanize($field['name'])."')); ?>\n";
				break;

				default:
					echo "\t\t\t<?php echo Form::input('{$field['name']}', Input::post('{$field['name']}', isset(\$item) ? \$item->{$field['name']} : ''), ".
						"array('class' => 'form-control', 'placeholder'=>'".\Inflector::humanize($field['name'])."')); ?>\n";

endswitch; ?>

		</div>
<?php endforeach; ?>

		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo '<?php'; ?> echo Form::submit('submit', __('trait-crud.button.Save'), array('class' => 'btn btn-primary')); <?php echo '?>'; ?>
			
		</div>
		
<?php if ($csrf): ?>
	<?php echo '<?php'; ?> echo Form::hidden(Config::get('security.csrf_token_key'), Security::fetch_token()); <?php echo '?>'; ?>
<?php endif; ?>
<?php echo '<?php'; ?> echo Form::close(); <?php echo '?>'; ?>



<?php echo '<?php else: ?>' ?>


<table class="table table-striped">
	<thead>
		<tr>
<?php foreach ($fields as $field): ?>
			<th><?php echo "<?php echo __('model.{$singular_name}.{$field['name']}'); ?>";?></th>
<?php endforeach; ?>
			<th style="width:3em;"><?php echo '<?php'; ?> echo Html::anchor('#', __('trait-crud.button.Add_new_MODEL', array('model'=>__('model.<?php echo $singular_name;?>._name'))), array('class' => 'btn btn-success btn-include_form_create')); <?php echo '?>'; ?></th>
		</tr>
	</thead>
	<tbody>
	<?php echo '<?php'; ?> if( $items ): <?php echo '?>'; ?>
	<?php echo '<?php'; ?> foreach($items as $key => $item): <?php echo '?>'; ?>
		<tr>
		
<?php foreach ($fields as $field): ?>

		<td class="form-group<?php echo '<?php echo ($errors && $val->error(\''.$singular_name.'.\'.$key.\'.'.$field['name'].'\'))?" has-error":""; ?>';?>">

<?php switch($field['type']):

				case 'text':
					echo "\t\t\t<?php echo Form::textarea('{$singular_name}['.\$key.'][{$field['name']}]', \$item->{$field['name']}, \n".
						"\t\t\t\tarray('class' => 'form-control', 'rows' => 1, 'placeholder'=>__('placeholder.model.{$singular_name}.{$field['name']}'))); ?>\n";
				break;

				default:
					echo "\t\t\t<?php echo Form::input('{$singular_name}['.\$key.'][{$field['name']}]', \$item->{$field['name']}, \n".
						"\t\t\t\tarray('class' => 'form-control', 'placeholder'=>__('placeholder.model.{$singular_name}.{$field['name']}'))); ?>\n";

endswitch; ?>

		</td>
<?php endforeach; ?>
			<td>
				<?php echo Html::anchor('#', __('trait-crud.button.Delete'), array('class' => 'btn btn-danger btn-include_form_delete')); ?>
			</td>
		</tr>
	<?php echo '<?php'; ?> endforeach; <?php echo '?>'; ?>
	<?php echo '<?php'; ?> endif; <?php echo '?>'; ?>
	</tbody>
	<tbody style="display:none;" class="include_layout">
		<tr>
<?php foreach ($fields as $field): ?>

		<td class="form-group">

<?php switch($field['type']):

				case 'text':
					echo "\t\t\t<?php echo Form::textarea('{$singular_name}[INDEX][{$field['name']}]', '', \n".
						"\t\t\t\tarray('class' => 'form-control', 'rows' => 1, 'placeholder'=>__('placeholder.model.{$singular_name}.{$field['name']}'), 'disabled' => 'disabled')); ?>\n";
				break;

				default:
					echo "\t\t\t<?php echo Form::input('{$singular_name}[INDEX][{$field['name']}]', '', \n".
						"\t\t\t\tarray('class' => 'form-control', 'placeholder'=>__('placeholder.model.{$singular_name}.{$field['name']}'), 'disabled' => 'disabled')); ?>\n";

endswitch; ?>

		</td>
<?php endforeach; ?>
			<th>
				<?php echo Html::anchor('#', __('trait-crud.button.Delete'), array('class' => 'btn btn-danger btn-include_form_delete')); ?>
			</th>
		</tr>
	</tbody>
</table>


<?php echo '<?php endif; ?>' ?>