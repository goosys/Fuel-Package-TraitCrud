<?php
	$model_name = __('model.'.$model.'._name');
	switch($show){
		case 'L':
			$title = __('trait-crud.message.Listing_MODEL', array('model'=>$model_name));
			break;
			
		case 'V':
			$title = __('trait-crud.message.Viewing_MODEL_NUM', array('model'=>$model_name,'id'=>$item->id));
			break;
			
		case 'C':
			$title = __('trait-crud.message.New_MODEL', array('model'=>$model_name));
			break;
			
		case 'E':
			$title = __('trait-crud.message.Editing_MODEL', array('model'=>$model_name,'id'=>$item->id));
			break;
		
		default:
			$title = '';
			break;
	}
	View::set_global('subtitle',$title);
?>
<h2><?php echo $title; ?></h2><br>
