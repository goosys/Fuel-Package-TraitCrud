				<?php echo Html::anchor($uri.'/view/'.$item->id, __('trait-crud.button.View')); ?> |
				<?php echo Html::anchor($uri.'/edit/'.$item->id, __('trait-crud.button.Edit')); ?> |
				<?php echo Html::anchor($uri.'/delete/'.$item->id, __('trait-crud.button.Delete'), array('onclick' => "return confirm('".__('trait-crud.message.Are_you_sure')."')")); ?>