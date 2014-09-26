<?php 
	$show   = (isset($show  ) && !empty($show  ))? $show  : 'L';
?>
<ul class="pager">
<?php if( strpos($show,'L')!==false ): ?><li><?php echo Html::anchor($uri, __('trait-crud.button.List')); ?></li><?php endif; ?>
<?php if( strpos($show,'V')!==false ): ?><li><?php echo Html::anchor($uri.'/view/'.$item->id, __('trait-crud.button.View')); ?></li><?php endif; ?>
<?php if( strpos($show,'E')!==false ): ?><li><?php echo Html::anchor($uri.'/edit/'.$item->id, __('trait-crud.button.Edit')); ?></li><?php endif; ?>
</ul>
