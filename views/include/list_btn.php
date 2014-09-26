<?php 
	$layout = (isset($layout) && !empty($layout))? $layout: 'button';
	$show   = (isset($show  ) && !empty($show  ))? $show  : 'VED';
?>
<?php if($layout=='text'): ?>
				<?php if( strpos($show,'V')!==false ){ echo Html::anchor($uri.'/view/'  .$item->id, __('trait-crud.button.View'  )).' | '; } ?>
				<?php if( strpos($show,'E')!==false ){ echo Html::anchor($uri.'/edit/'  .$item->id, __('trait-crud.button.Edit'  )); } ?>
				<?php if( strpos($show,'D')!==false ){ echo ' | '.Html::anchor($uri.'/delete/'.$item->id, __('trait-crud.button.Delete'), array('onclick' => "return confirm('".__('trait-crud.message.Are_you_sure')."')")); } ?>

<?php elseif($layout=='icon'): ?>
				<?php if( strpos($show,'V')!==false ){ echo Html::anchor($uri.'/view/'  .$item->id, '<span class="glyphicon glyphicon-list"  ></span>', array('title'=>__('trait-crud.button.View'  )) ); } ?>
				<?php if( strpos($show,'E')!==false ){ echo Html::anchor($uri.'/edit/'  .$item->id, '<span class="glyphicon glyphicon-pencil"></span>', array('title'=>__('trait-crud.button.Edit'  )) ); } ?>
				<?php if( strpos($show,'D')!==false ){ echo Html::anchor($uri.'/delete/'.$item->id, '<span class="glyphicon glyphicon-trash" ></span>', array('title'=>__('trait-crud.button.Delete'), 'onclick' => "return confirm('".__('trait-crud.message.Are_you_sure')."')")); } ?>

<?php elseif($layout=='button'): ?>
				<?php if( strpos($show,'V')!==false ){ echo Html::anchor($uri.'/view/'  .$item->id, '<span class="glyphicon glyphicon-list"  > '. __('trait-crud.button.View'  ) .'</span>', array('class'=>'btn btn-info    btn-xs') ); } ?>
				<?php if( strpos($show,'E')!==false ){ echo Html::anchor($uri.'/edit/'  .$item->id, '<span class="glyphicon glyphicon-pencil"> '. __('trait-crud.button.Edit'  ) .'</span>', array('class'=>'btn btn-primary btn-xs') ); } ?>
				<?php if( strpos($show,'D')!==false ){ echo Html::anchor($uri.'/delete/'.$item->id, '<span class="glyphicon glyphicon-trash" > '. __('trait-crud.button.Delete') .'</span>', array('class'=>'btn btn-danger  btn-xs', 'onclick' => "return confirm('".__('trait-crud.message.Are_you_sure')."')")); } ?>

<?php endif; ?>