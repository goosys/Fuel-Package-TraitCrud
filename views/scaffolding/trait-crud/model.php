<?php echo '<?php' ?>

use Orm\Model;

class Model_<?php echo $model_name; ?> extends Model
{
	protected static $_properties = array(
		'id',
<?php $maxlen=0; foreach($fields as $f){ if(strlen($f['name'])>$maxlen){ $maxlen = strlen($f['name']);  } } ?>
<?php foreach ($fields as &$field): ?>
<?php $field['formatted_name']  = sprintf('%-'.($maxlen+2).'s', '\''.$field['name'].'\''); ?>
<?php $field['formatted_name2'] = sprintf('%-'.($maxlen+1).'s',      $field['name'].'\''); ?>
		<?php echo $field['formatted_name']; ?>,
<?php endforeach; ?>
<?php if ($include_timestamps): ?>
		'created_at',
		'updated_at',
<?php endif; ?>
	);

	protected static $_observers = array(
<?php if ($include_timestamps): ?>
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
<?php endif; ?>
	);
	
	protected static $_belongs_to = array(
	);
	
	protected static $_has_many= array(
	);
	
	protected static $_has_one = array(
	);

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
<?php foreach ($fields as &$field): ?>
<?php
		$rules = array('required');

		if (in_array($field['type'], array('varchar', 'string', 'char')))
		{
			if ($field['name'] === 'email')
			{
				$rules[] = 'valid_email';
			}
			$rules[] = ! is_null($field['constraint']) ? "max_length[{$field['constraint']}]" : 'max_length[255]';
		}
		elseif (in_array($field['type'], array('int', 'integer')))
		{
			$rules[] = 'valid_string[numeric]';
		}

		$rules = implode('|', $rules);
		$field['rules'] = $rules;
?>
		$val->add_field(<?php echo $field['formatted_name']; ?>, __('model.<?php echo $singular_name; ?>.<?php echo $field['formatted_name2']; ?>), '<?php echo $field['rules'];//' ?>');
<?php endforeach; ?>

		/* Relational Validation Sample 
		if( Input::post('child') ){
			foreach( Input::post('child') as $id => $p ){
				$val = Model_Child::validate_relation($val,$id);
			}
		}
		*/

		return $val;
	}

	public static function validate_relation($val,$id)
	{
<?php foreach ($fields as &$field): ?>
		$val->add_field('<?php echo $singular_name;?>.'.$id.'.<?php echo $field['formatted_name2']; ?>, __('model.<?php echo $singular_name; ?>.<?php echo $field['formatted_name2']; ?>), '<?php echo $field['rules']; ?>');
<?php endforeach; ?>

		return $val;
	}

}

<?php echo '/*';?> Please copy these to lang/en/model.php
	'<?php echo $singular_name; ?>' => array(
		'_name' => '<?php echo $model_name; ?>',
<?php foreach ($fields as &$field): ?>
		<?php echo $field['formatted_name']; ?> => '<?php echo \Str::ucfirst($field['name']); ?>',
<?php endforeach; ?>
<?php if ($include_timestamps): ?>
		'created_at' => 'Created at',
		'updated_at' => 'Updated at',
<?php endif; ?>
	),
<?php echo '*/'; ?>
