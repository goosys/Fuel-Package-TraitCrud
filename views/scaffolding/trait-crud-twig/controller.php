<?php echo '<?php' ?>

class <?php echo \Config::get('controller_prefix', 'Controller_').$controller_name; ?> extends <?php echo \Cli::option('extends', $controller_parent) ?>
{
	use Trait_Crud;
	
	public function before(){
		static::$model_name       = 'Model_<?php echo $model_name; ?>';
		static::$controller_name  = 'Controller_<?php echo $controller_name; ?>';
		static::$func_validate    = 'validate';
		parent::before();
	}
	
<?php foreach ($actions as $action): ?>
	public function action_<?php echo $action['name']; ?>(<?php echo $action['params']; ?>)
	{
<?php echo $action['code'].PHP_EOL; ?>
	}

<?php endforeach; ?>

}
