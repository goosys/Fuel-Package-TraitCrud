<?php echo '<?php' ?>

use Orm\Model;

class Model_<?php echo $model_name; ?> extends Model
{
	protected static $_properties = array(
		'id',
<?php $maxlen=0; foreach($fields as $f){ if(strlen($f['name'])>$maxlen){ $maxlen = strlen($f['name']);  } } ?>
<?php foreach ($fields as $field): ?>
<?php $field['formatted_name']  = sprintf('%-'.($maxlen+2).'s', '\''.$field['name'].'\''); ?>
<?php $field['formatted_name2'] = sprintf('%-'.($maxlen+1).'s',      $field['name'].'\''); ?>
		<?php echo $field['formatted_name']; ?>,
<?php endforeach; ?>
<?php if ($include_timestamps): ?>
		'created_at',
		'updated_at',
<?php endif; ?>
	);

<?php if ($include_timestamps): ?>
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);
<?php endif; ?>

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
<?php foreach ($fields as $field): ?>
<?php $field['formatted_name']  = sprintf('%-'.($maxlen+2).'s', '\''.$field['name'].'\''); ?>
<?php $field['formatted_name2'] = sprintf('%-'.($maxlen+1).'s',      $field['name'].'\''); ?>
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
?>
		$val->add_field(<?php echo $field['formatted_name']; ?>, __('model.<?php echo $singular_name; ?>.<?php echo $field['formatted_name2']; ?>), '<?php echo $rules; ?>');
<?php endforeach; ?>

		return $val;
	}

}
