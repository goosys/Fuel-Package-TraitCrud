		$this->_action_create();
		
		$data = array('item'=> $this->stash['model']);
		return Response::forge( View_Twig::forge('<?php echo $view_path ?>/create.twig',$data) );
